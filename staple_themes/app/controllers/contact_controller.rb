class ContactController < ApplicationController
    def new
    end
    def create
        if params[:name] && params[:email] && params[:body] && params[:type]
            message = OpenStruct.new({name: ActionView::Base.full_sanitizer.sanitize(params[:name]), email: ActionView::Base.full_sanitizer.sanitize(params[:email]), type:ActionView::Base.full_sanitizer.sanitize(params[:type]), body:ActionView::Base.full_sanitizer.sanitize(params[:body])})
            SiteMailer.contact(message).deliver
            render json:{}, status: :ok
        else
            render json:{message:"The name, email, body, and type params are required"}, status: :bad_request
        end
    end
end