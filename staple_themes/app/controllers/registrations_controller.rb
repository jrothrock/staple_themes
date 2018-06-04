class RegistrationsController < Devise::RegistrationsController  
    after_action :set_csrf_headers, only: [:create]

    respond_to :json

    def destroy
        # This would remove the users UUID from the themes, but isn't really personal identification as the record containing what the UUID refers to would be deleted

        # orders = Order.where("user_id = ?", current_user.id)
        # if orders.length
        #     theme_ids = orders.map(&:themes).flatten.uniq
        #     themes = Theme.where("id in (?)", theme_ids)
        #     themes.each do |theme|
        #         theme.purchasers = theme.purchasers.tap { |purchasers| purchasers.delete(current_user.uuid) }
        #         theme.save! 
        #     end
        # end
        super
        # App.purge_cache
    end

    protected

    def set_csrf_headers
        if request.xhr?
            session[:_csrf_token] = SecureRandom.base64(32)
            response.headers['X-CSRF-TOKEN'] = session[:_csrf_token]
        end
    end
end  