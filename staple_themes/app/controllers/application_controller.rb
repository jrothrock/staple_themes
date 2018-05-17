class ApplicationController < ActionController::Base
  protect_from_forgery prepend: true
  before_action :configure_permitted_parameters, if: :devise_controller?
  before_action :get_order
  before_action :get_analytics
  before_action :set_domains, if: :user_signed_in?

  protected

  def configure_permitted_parameters
    added_attrs = [:username, :email, :password, :password_confirmation, :remember_me, :compliance_agreement, :compliance_agreement_date, :email_agreement, :email_agreement_date]
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

  def get_analytics
    if !cookies[:eu_country].nil?
      @EU = ActiveModel::Type::Boolean.new.cast(cookies[:eu_country])
    elsif cookies[:country_set_id]
      is_eu = $redis.get("country_set_id_#{cookies[:country_set_id]}")
      if !is_eu.nil?
        cookies[:eu_country] = {
          value: ActiveModel::Type::Boolean.new.cast(is_eu),
          expires: Time.zone.now + 1.year,
          domain: 'staplethemes.com'
        }
        $redis.del("country_set_id_#{cookies[:country_set_id]}")
      end
      cookies.delete :country_set_id
      @EU = is_eu.nil? ? true : ActiveModel::Type::Boolean.new.cast(is_eu)
    else
      country_set_id = SecureRandom.hex(5)
      cookies[:country_set_id] = country_set_id
      CountryWorker.perform_async(request.remote_ip, country_set_id)
      @EU = true
    end
  end

  def set_domains
    @domains = Hosting.where("status > 1 AND user_id = ?", current_user.id)
  end


end
