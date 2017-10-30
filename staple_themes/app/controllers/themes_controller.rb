class ThemesController < ApplicationController
  before_action :authenticate_user!
  before_action :is_admin, only: [:edit, :update, :destroy]
  before_action :set_theme, only: [:read, :edit, :update, :destroy, :like]

  def index
    @themes = Theme.all.order('created_at DESC')
  end
  def read
  end
  
  def new
    @theme = current_user.themes.build
  end

  def create
    # puts post_params[:photos]
    @theme = current_user.themes.new(post_params.except(:photos))
    # @theme = current_user.themes.build(post_params.except(:photos))
    if @theme.save
      if post_params[:photos]
        post_params[:photos].each do |photo|
          @theme.photos.create(photo:photo)
        end
      end
      flash[:success] = "Theme has been created!"
      redirect_to root_path
    else
      flash[:alert] = "Theme couldn't be created. Please check the form."
      render :new
    end
  end

  def upload
    name = params[:name] ? params[:name] : 'temp-#{Time.now.to_s}'
    fields = Aws::S3::Resource.new(access_key_id: Rails.application.secrets.aws_access_key_id, secret_access_key: Rails.application.secrets.aws_secret_access_key, region: "us-west-2").bucket(Rails.application.secrets.aws_bucket).object("downloads/#{name}").presigned_post.fields
    puts fields
    @policy = fields["policy"]
    @signature = fields["x-amz-signature"]
    @credential = fields["x-amz-credential"]
    @content = fields["Content-Type"]
    @date_stamp = fields["x-amz-date"]
    @store = "downloads/#{name}"
    render json:{store: @store, policy: @policy, signature: @signature, credential: @credential, content: @content, date_stamp: @date_stamp}, status: :ok
  end

  def edit
  end

  def update
    if @theme.update(post_params)
      flash[:success] = "Post updated."
      redirect_to root_path
    else
      flash[:alert] = "Update failed. Please check the form."
      render :edit
    end
  end

  def destroy
    @theme.update(deleted:true)
    flash[:success] = "The theme has been hidden."
    redirect_to root_path
  end

  # def rating
    # if @post.liked_by current_user
    #   respond_to do |format|
    #     format.html { redirect_to :back }
    #     format.js
    #   end
    # end
  # end

  private

  def add_more_images(new_images)
    images = @theme.photos # copy the old images 
    images += new_images # concat old images with new ones
    @theme.photos = images # assign back
  end

  def post_params
    params.require(:theme).permit(:title, :description, :zip, :price, :sale_price, :url, photos: [])
  end

  def set_post
    @theme = Theme.find(params[:id])
  end

  def is_admin
    unless current_user.admin
      flash[:alert] = "\"I'm sorry Dave, I'm afraid I can't do that\""
      redirect_to root_path
    end
  end

end