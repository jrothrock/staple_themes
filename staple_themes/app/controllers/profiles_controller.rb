class ProfilesController < ApplicationController
  before_action :set_user
  # before_action :owned_profile

  def show
  end

  # def owned_profile
  #   unless current_user == @user
  #     flash[:alert] = "That profile doesn't belong to you!"
  #     redirect_to root_path
  #   end
  # end

  def set_user
    @user = User.find_by(username: params[:profile])
  end
end