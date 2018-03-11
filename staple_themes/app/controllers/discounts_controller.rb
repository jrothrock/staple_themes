class DiscountsController < ApplicationController
    before_action :is_admin
    before_action :set_discount, only: [:edit, :update, :destroy]
    def index
        @discounts = Discount.all
    end
    def show
    end
    def new
        @discount = Discount.new
    end
    def create
        @discount = Discount.new
        @discount.name = params[:discount][:name]
        @discount.code = params[:discount][:code]
        @discount.amount = params[:discount][:amount].to_f > 1 ? params[:discount][:amount].to_f / 100 : params[:discount][:amount].to_f
        @discount.expired = parmas[:discount][:expired]
        if @discount.save
            flash[:success] = "Discount Code has been created!"
            redirect_to discounts_path
        else
            flash[:alert] = "Discount Code couldn't be created. Please check the form."
            render :new
        end
    end
    def edit
    end
    def update
        @discount.assign_attributes(post_params)
        if @discount.save
            flash[:success] = "Discount Code has been updated!"
            redirect_to discounts_path
        else
            flash[:alert] = "Discount Code couldn't be updated. Please check the form."
            render :edit
        end
    end 
    def delete
    end

    private

    def post_params
        params.require(:discount).permit(:name, :code, :amount, :expired)
    end

    def set_discount
        @discount = Discount.find_by_id(params[:id])
        unless current_user.try(:admin?)
        flash[:alert] = "\"I'm sorry Dave, I'm afraid I can't let you do that\""
        redirect_to root_path
        end
    end

    def is_admin
        unless current_user.try(:admin?)
        flash[:alert] = "\"I'm sorry Dave, I'm afraid I can't let you do that\""
        redirect_to root_path
        end
    end
end