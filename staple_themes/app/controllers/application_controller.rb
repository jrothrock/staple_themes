class ApplicationController < ActionController::Base
  protect_from_forgery
  before_action :configure_permitted_parameters, if: :devise_controller?
  before_action :get_order
  before_action :set_domains, if: :user_signed_in?


  protected

  def configure_permitted_parameters
    added_attrs = [:username, :email, :password, :password_confirmation, :remember_me]
    devise_parameter_sanitizer.permit :sign_up, keys: added_attrs
    devise_parameter_sanitizer.permit :account_update, keys: added_attrs
  end

  def get_order
    if session[:order_id]
      @order = Order.where("uuid = ?", session[:order_id]).first.as_json
      if @order
        theme_ids = @order['themes']
        themes = Theme.where("id in (?)", theme_ids).as_json({:include => :photos})
        @order['themes'] = themes
        hosting_ids = @order['plans']
        hostings = Hosting.where("id in (?)", hosting_ids)
        @order['plans'] = hostings
      end
    end
  end

  def set_domains
    @domains = Hosting.where("status > 1 AND user_id = ?", current_user.id)
  end


end
