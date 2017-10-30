class OrdersController < ApplicationController
  include PayPal::SDK::REST
  include PayPal::SDK::Core::Logging

  before_action :authenticate_user!
  before_action :set_user
  before_action :owned_profile

  def index
    @orders = @user.orders.order('created_at DESC')
  end

  def create
    @order = current_user.themes.build(post_params)
  end

  def read
    @order = ApplicationRecord::Order.find_by_id(params[:order])
    
  end

  def update
    @order = ApplicationRecord::Order.find_by_id(params[:order])
    themes = Theme.where("id IN (?)", @order.themes)
    themes.each do |theme|
      theme.purchasers[current_user.username] = 1
      theme.purchases += 1
      theme.save
    end
    @order.email = params[:email] ? params[:email] : order.email
    @order.status = 2
    ApplicationRecord::Order.transaction do
        begin
            if order.save
              if params[:paypal] === true || params[:paypal] === "true"
                if !params[:paymentID] || !params[:payerID]
                  render json:{}, status: :internal_server_error
                  return false
                end
                begin
                  mode = Rails.env.production? ? 'live' : 'sandbox'
                  PayPal::SDK::REST.set_config(
                      :mode => mode, # "sandbox" or "live"
                      :client_id => Rails.application.secrets.paypal_id,
                      :client_secret => Rails.application.secrets.paypal_secret
                  )
                  payment = Payment.find(params[:paymentID])
                  if payment.execute( :payer_id => params[:payerID] )  # return true or false
                      puts "Payment[#{payment.id}] executed successfully"
                  else
                      raise "payment execution failed"
                  end
                rescue Exception => e
                    Rails.logger.info(e.inspect)
                    Rails.logger.info(e.backtrace)
                    Rails.logger.info(payment.error.inspect)
                    ExceptionNotifier.notify_exception(e,
                                :env => request.env, :data => {:message => "Paypal Order Payment Has Failed. Error: #{e.inspect}, #{e.backtrace}, Payment:#{payment.error.inspect}"})
                    render json:{paylpal_fail:true, message:'paypal error', error:payment.error}, status: :internal_server_error
                    Product.rollProductsBack(user,products,products_old_quantities,purchased_already)
                    raise ActiveRecord::Rollback
                end
              else
                Stripe.api_key =  Rails.application.secrets.stripe
                puts Stripe.api_key
                puts Stripe::Charge.as_json
                # Get the credit card details submitted by the form
                token = params[:token]
                amount = (order.total * 100).to_i

                # Create a charge: this will charge the user's card
                begin
                    charge = Stripe::Charge.create(
                        :amount => amount, # Amount in cents
                        :currency => "usd",
                        :source => token,
                        :description => `Charge for order #{order.uuid}`,
                        :transfer_group => "ORDER_#{order.uuid}",
                    )
                rescue Stripe::CardError => e
                    Rails.logger.info(e)
                    render json:{card_fail:true, message:'card error'}, status: :internal_server_error
                    Product.rollProductsBack(user,products,products_old_quantities,purchased_already)
                    raise ActiveRecord::Rollback
                    return false
                rescue => e
                    Rails.logger.info(e)
                    ExceptionNotifier.notify_exception(e,
                                :env => request.env, :data => {:message => "Paypal Stripe Payment Has Failed. Error: #{e.inspect}, #{e.backtrace}"})
                    render json:{message:"failed in the stripe payment"}, status: :internal_server_error
                    Product.rollProductsBack(user,products,products_old_quantities,purchased_already)
                    raise ActiveRecord::Rollback
                    return false
                end
              end
              render json:{order:order.as_json.except("paid_with","stripe_payment_id", "stripe_payout_ids", "paypal_payment_id", "paypal_payouts_id", "tracker_sent", "tracker_updated")}, status: :ok
              # NotifysellerWorker.perform_in(15.seconds)
              # if user.is_a? String
              #     user = OpenStruct.new({username: order.firstname, email:order.email})
              # end
              # ApplicationRecord::Order.sendEmails(order,user)
              # puts clear_cache_ids
              # if clear_cache_ids.length
              #     clear_cache_ids.keys.each do |key|
              #         PurgecacheWorker.perform_async(clear_cache_ids[key],key,clear_cache_ids[key])
              #     end
              # end
            else
                render json:{}, status: :internal_server_error
                Product.rollProductsBack(user,products,products_old_quantities,purchased_already)
                Rails.logger.info(order.errors.inspect)
            end
          rescue => e
              # render json:{}, status: :internal_server_error
              puts e
              ExceptionNotifier.notify_exception(e,
                  :env => request.env, :data => {:message => "Order Has Failed. Error: #{e.inspect}, #{e.backtrace}"})
              if Rails.env.production?
                  # render json:{error:e}, status: :internal_server_error
              else
                  # render json:{error:e, backtrace: e.backtrace}, status: :internal_server_error
              end
              # Product.rollProductsBack(user,products,products_old_quantities,purchased_already)
          end
        end
  end

  private 

  def owned_profile
    unless current_user == @user
      flash[:alert] = "That profile doesn't belong to you!"
      redirect_to root_path
    end
  end

  def set_user
    @user = User.find_by(username: params[:profile])
  end
end