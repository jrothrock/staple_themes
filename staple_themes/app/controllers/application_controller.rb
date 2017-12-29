class ApplicationController < ActionController::Base
  protect_from_forgery with: :exception
  before_action :configure_permitted_parameters, if: :devise_controller?
  before_action :get_order


  protected

  def configure_permitted_parameters
    added_attrs = [:username, :email, :password, :password_confirmation, :remember_me]
    devise_parameter_sanitizer.permit :sign_up, keys: added_attrs
    devise_parameter_sanitizer.permit :account_update, keys: added_attrs
  end

  def get_order
    if(session[:order_id])
      @order = Order.where("uuid = ?", session[:order_id]).first.as_json
      if @order
        theme_ids = @order['themes']
        themes = Theme.where("id in (?)", theme_ids).as_json({:include => :photos})
        @order['themes'] = themes
      end
    end
  end

end
