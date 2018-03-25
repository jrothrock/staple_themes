class HostingController < ApplicationController
    before_action :authenticate_user!, only: [:new, :update, :destroy]
    def index
    end
    def show
    end
    def new
        @plan = params[:plan]
    end
    def create
        if params[:name] && params[:email] && params[:domain] && params[:plan]
            message = OpenStruct.new({name: ActionView::Base.full_sanitizer.sanitize(params[:name]), email: ActionView::Base.full_sanitizer.sanitize(params[:email]), domain:ActionView::Base.full_sanitizer.sanitize(params[:domain]), plan:ActionView::Base.full_sanitizer.sanitize(params[:plan])})
            SiteMailer.hosting(message).deliver
            render json:{}, status: :ok
        else
            render json:{message:"The name, email, body, and type params are required"}, status: :bad_request
        end
    end
    def update
    end
    def delete
    end
end