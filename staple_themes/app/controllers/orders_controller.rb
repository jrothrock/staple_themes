include ActionView::Helpers::NumberHelper
class OrdersController < ApplicationController
  # include PayPal::SDK::REST
  # include PayPal::SDK::Core::Logging
  before_action :authenticate_user!
  before_action :set_user, only: [:index]
  before_action :owned_profile, only: [:index]

  def index
    @orders = current_user.orders.where("status = 2").order('created_at DESC').as_json
    @orders.map do |order|
      theme_ids = order['themes']
      themes = Theme.where("id in (?)", theme_ids).as_json({:include => :photos})
      order['themes'] = themes
    end
  end

  def create
    if params[:license] && (params[:theme] || params[:host])
      theme = Theme.where("id = ?", params[:theme]).first.as_json({:include => :photos})
      if theme
        @order = current_user.orders.new
        if params[:license].to_i === 1
          @order.total = theme['single_sale_price'] ? theme['single_sale_price'] : theme['single_price']
        elsif params[:license].to_i === 2
          @order.total = theme['multi_sale_price'] ? theme['multi_sale_price'] : theme['multi_price']
        else
          render json:{message:"license needs to be either a \"1\" for single use or a \"2\" for multi use."}, status: :bad_request
          return false
        end
        @order.themes = [params[:theme]]
        @order.licenses = [params[:license]]
        if @order.save
          session[:order_id] = @order.uuid
          order = @order.as_json
          order['total'] = number_to_currency(order['total'])
          theme['single_sale_price'] = theme['single_sale_price'] != nil ? number_to_currency(theme['single_sale_price']) : theme['single_sale_price'];
          theme['single_price'] = theme['single_price'] != nil ? number_to_currency(theme['single_price']) : theme['single_price'];
          theme['multi_sale_price'] = theme['multi_sale_price'] != nil ? number_to_currency(theme['multi_sale_price']) : theme['multi_sale_price'];
          theme['multi_price'] = theme['multi_price'] != nil ? number_to_currency(theme['multi_price']) : theme['multi_price'];
          render json:{order:order, theme:theme, index: 0, license: params[:license].to_i}, status: :ok
        else
          render json:{}, status: :internal_server_error
          Rails.logger.info(@order.errors.inspect) 
        end
      else
        render json:{message:"Theme was not found, please check the id and try again"}, status: :not_found
      end
    else
      render json:{message:"Both the themes param and license param are required"}, status: :bad_request
    end
  end

  def show
    if(request.headers['X-Cart'])
        order = ApplicationRecord::Order.where("uuid = ?", params[:id]).first
        if order
            session[:order_id] = order.uuid
            render json:{}, status: :ok
        end
    end    
  end

  def update
    @order = ApplicationRecord::Order.where('uuid = ? AND user_id = ? AND status = 1',params[:id], current_user.id).first
    if(@order)
      theme = Theme.where("id = ?", params[:theme]).first.as_json({:include => :photos})
      if(theme)
        if(params[:update_type].to_i === 1)
          index = @order.themes.index(params[:theme])
          update = false
          if(index != nil)
            license = @order.licenses[index]
            if license.to_i === 1
              @order.total -= theme['single_sale_price'] ? theme['single_sale_price'] : theme['single_price']
              @order.discounted_total = @order.discounted ? @order.discounted_total - (theme['single_sale_price'] ? theme['single_sale_price'] * (1 - @order.discount) : theme['single_price'] * (1 - @order.discount)) : @order.discounted_total
            else
              @order.total -= theme['multi_sale_price'] ? theme['multi_sale_price'] : theme['multi_price']
              @order.discounted_total = @order.discounted ? @order.discounted_total - (theme['multi_sale_price'] ? theme['multi_sale_price'] * (1 - @order.discount) : theme['multi_price'] * (1 - @order.discount)) : @order.discounted_total
            end
            @order.licenses[index] = params[:license]
            update = true
          end
          if params[:license].to_i === 1
            @order.total += theme['single_sale_price'] ? theme['single_sale_price'] : theme['single_price']
            @order.discounted_total = @order.discounted ? @order.discounted_total + (theme['single_sale_price'] ? theme['single_sale_price'] * (1 - @order.discount) : theme['single_price'] * (1 - @order.discount)) : @order.discounted_total
          elsif params[:license].to_i === 2
            @order.total += theme['multi_sale_price'] ? theme['multi_sale_price'] : theme['multi_price']
            @order.discounted_total = @order.discounted ? @order.discounted_total + (theme['multi_sale_price'] ? theme['multi_sale_price'] * (1 - @order.discount) : theme['multi_price'] * (1 - @order.discount)) : @order.discounted_total
          else
            render json:{message:"license needs to be either a \"1\" for single use or a \"2\" for multi use."}, status: :bad_request
            return false
          end
          if(index == nil)
            @order.themes << params[:theme]
            @order.licenses << params[:license]
          end
          if @order.save
            order = @order.as_json
            order['total'] = number_to_currency(order['total'])
            order['discounted_total'] = order['discounted_total'] != nil ? number_to_currency(order['discounted_total']) : nil
            theme['single_sale_price'] = theme['single_sale_price'] != nil ? number_to_currency(theme['single_sale_price']) : theme['single_sale_price'];
            theme['single_price'] = theme['single_price'] != nil ? number_to_currency(theme['single_price']) : theme['single_price'];
            theme['multi_sale_price'] = theme['multi_sale_price'] != nil ? number_to_currency(theme['multi_sale_price']) : theme['multi_sale_price'];
            theme['multi_price'] = theme['multi_price'] != nil ? number_to_currency(theme['multi_price']) : theme['multi_price'];
            render json:{order:order, theme:theme, index: (index ? index : order['themes'].length - 1), license: (params[:license].to_i === 1 ? 'Single' : 'Multi'), update:update }, status: :ok
          else
            render json:{}, status: :internal_server_error
            Rails.logger.info(@order.errors.inspect) 
          end
        elsif(params[:update_type].to_i === 2)
          index = @order.themes.index(params[:theme])
          if(index != nil)
            license = @order.licenses[index]
            if(license).to_i === 1
              @order.total -= theme['single_sale_price'] ? theme['single_sale_price'] : theme['single_price']
              @order.discounted_total = @order.discounted ? @order.discounted_total - (theme['single_sale_price'] ? theme['single_sale_price'] * ( 1 - @order.discount) : theme['single_price'] * (1 - @order.discount)) : @order.discounted_total
            else
              @order.total -= theme['multi_sale_price'] ? theme['multi_sale_price'] : theme['multi_price']
              @order.discounted_total = @order.discounted ? @order.discounted_total - (theme['multi_sale_price'] ? theme['multi_sale_price'] * (1 - @order.discount) : theme['multi_price'] * (1 - @order.discount)) : @order.discounted_total
            end
            @order.themes.delete_at(index)
            @order.licenses.delete_at(index)
            if @order.save
              order = @order.as_json
              order['total'] = number_to_currency(order['total'])
              order['discounted_total'] = order['discounted'] ? number_to_currency(order['discounted_total']) : order['discounted_total']
              render json:{order:order}, status: :ok
            else
              render json:{}, status: :ok
              Rails.logger.info(@order.errors.inspect) 
            end
          else
            render json:{message: "Your order does not contain that theme"}, status: :bad_request
          end
        else
          render json:{message:"'update_type' param needs to be present, being either 1 for adding an item, or 2 for deleting an item"}, status: :bad_request
        end
      else
        render json:{message: "Theme was not found"}, status: :not_found
      end
    else
      render json:{message:"Order was not found"}, status: :not_found
    end
  end

  def discount
    @order = ApplicationRecord::Order.where('uuid = ? AND user_id = ? AND status = 1',params[:id], current_user.id).first
    if @order
      discount = Discount.where("code = ?", params[:code]).first
      if discount && !discount.expired
        if !@order.discounted
          @order.discounted = true
          @order.discount = discount.amount
          @order.discounted_total = @order.total * (1-@order.discount)
          @order.discount_total = @order.total - @order.discounted_total
          @order.discount_code = params[:code]
          discount.uses += 1
          if @order.save && discount.save
            order = @order.as_json
            order['discounted_total'] = number_to_currency(order['discounted_total'])
            order['total'] = number_to_currency(order['total'])
            render json:{order: order}, status: :ok
          else
            render json:{}, status: :internal_server_error
          end
        else
          render json:{message:"Only one discount can be applied", discounted:true}, status: :bad_request
        end
      elsif discount && discount.expired
        render json:{message:"Code has expired", expired:true}, status: :bad_request
      else
        render json:{message:"Code was not found"}, status: :not_found
      end
    else
      render json:{message:"Order was not found"}, status: :not_found
    end
  end

  def delete

  end

  private 

  def owned_profile
    unless current_user == @user
      flash[:alert] = "That profile doesn't belong to you!"
      redirect_to root_path
    end
  end

  def post_params
    params.permit(:theme, :license)
  end

  def set_user
    @user = User.find_by(username: params[:profile])
  end
end