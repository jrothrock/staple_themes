class RegistrationsController < Devise::RegistrationsController  
    after_action :set_csrf_headers, only: [:create]
    respond_to :json

    protected

    def set_csrf_headers
        if request.xhr?
            session[:_csrf_token] = SecureRandom.base64(32)
            response.headers['X-CSRF-TOKEN'] = session[:_csrf_token]
        end
    end
end  