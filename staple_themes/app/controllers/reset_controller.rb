class ResetController < ApplicationController
    def show
    end

    def create
        user = User.where(["lower(username) = :value OR lower(email) = :value", { :value => params[:login].downcase }]).first
        if user
            User.resetPassword(user)
            flash[:success] = "Reset Confirmation Has Been Sent"
            render json:{}, status: :ok
        else
            render json:{}, status: :not_found
        end
    end

    def update
        if params[:token]
            user = User.where("reset_password_token = ?", params[:token]).first
            if user
                @user = user
            else
                flash[:alert] = "Reset Token Is Not Valid"
                redirect_to root_path
            end
        else
            flash[:alert] = "Reset Token Is Required"
            redirect_to root_path
        end
    end

    def update_password
        if params[:user_uuid]
            if params[:password]
                user = User.where("uuid = ?", params[:user_uuid]).first
                if user
                    user.password = params[:password]
                    user.save
                    sign_in(user)
                    flash[:success] = "Password Successfully Reset"
                    render json:{}, status: :ok
                else
                    render json:{message:"User not found"}, status: :not_found
                end
            else
                render json:{message:"password parameter is required"}, status: :bad_request
            end
        else
            render json:{message:"user_uuid parameter is required"}, status: :bad_request
        end
    end
end