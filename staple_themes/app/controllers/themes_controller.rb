class ThemesController < ApplicationController
  before_action :authenticate_user!, only: [:new, :edit, :update, :destroy, :download]
  before_action :is_admin, only: [:new, :edit, :update, :destroy]
  before_action :set_theme, only: [:show, :edit, :update, :destroy, :like, :upload, :download]

  def index
    @themes = $redis.get("themes_page")
    if @themes.nil?
      @themes = Theme.where("upload_status = 1").all.order('created_at DESC').includes(:photos)
      $redis.set("themes_page",@themes.to_json)
      $redis.rpush("all_keys", "themes_page")
    else
      @themes = JSON.parse(@themes)
    end
  end
  def show
  end
  
  def new
    @theme = current_user.themes.build
  end

  def create
    # puts post_params[:photos]
    @theme = current_user.themes.new(post_params.except(:photos))
    @theme.url = (/^http(s)?:\/\// =~ @theme.url) === 0 ? @theme.url : "https://#{@theme.url}"
    @theme.title_url = @theme.title.downcase.parameterize
    @theme.download_name = @theme.download_name ? @theme.download_name.gsub(".zip","") : ''
    @theme.download_url = "downloads/#{@theme.download_name.downcase.parameterize.underscore}"
    @theme.save
    if @theme.save
      if post_params[:photos]
        post_params[:photos].each do |photo|
          @theme.photos.create(photo:photo)
        end
      end
      flash[:success] = "Theme has been created!"
      PhotoWorker.perform_async(@theme.id)
      redirect_to root_path
    else
      flash[:alert] = "Theme couldn't be created. Please check the form."
      render :new
    end
  end

  def upload
    name = params[:name] ? params[:name].downcase.gsub(/\w/,'_').underscore : 'temp-#{Time.now.to_s}'
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
    @theme.assign_attributes(post_params)
    @theme.title_url = @theme.title.downcase.parameterize
    if @theme.save  
      flash[:success] = "Theme updated."
      redirect_to theme_path(@theme.title)
      PhotoWorker.perform_async(@theme.id)
    else
      flash[:alert] = "Update failed. Please check the form."
      render :edit
    end
  end

  def destroy
    @theme.update(deleted:true)
    flash[:success] = "The theme has been removed."
    redirect_to root_path
  end

  def download
    single = @theme['single_sale_price'] != nil ? @theme['single_sale_price'] : @theme['single_price']
    multi = @theme['multi_sale_price'] != nil ? @theme['multi_sale_price'] : @theme['multi_price']
    free = single === 0.00 && multi === 0.00
    if @theme['purchasers'].key?(current_user.uuid) || free
      @theme['downloads'] += 1
      url = Aws::S3::Presigner.new(:client=>Aws::S3::Client.new(region: "us-west-2",credentials:Aws::Credentials.new(Rails.application.secrets.aws_access_key_id, Rails.application.secrets.aws_secret_access_key))).presigned_url(:get_object, response_content_disposition:"attachment; filename=#{@theme['download_name']}.zip", bucket: Rails.application.secrets.aws_bucket, key: "#{@theme['download_url']}.zip",:expires_in=>600)
      @theme.save
      render json:{url:url}, status: :ok
    else
      render json:{}, status: :unauthorized
    end
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
    params.require(:theme).permit(:title, :description, :zip, :single_price, :single_sale_price, :multi_price, :multi_sale_price, :excerpt, :url, :download_name, photos: [])
  end

  def set_theme
    id = params[:theme] && params[:theme]['title'] ? params[:theme]['title'] : params[:id]
    if id || action_name === 'upload'
      if action_name === 'show'
        @theme = $redis.get("theme_#{id.downcase.parameterize}")
        if @theme.nil?
          @theme = Theme.where("title_url = ?", id.downcase.parameterize).first.to_json({:include => {:comments => {:include => :user}}})
          $redis.set("theme_#{id.downcase.parameterize}",@theme)
          $redis.rpush("all_keys", "theme_#{id.downcase.parameterize}")
        end
         @theme = JSON.parse(@theme)
      elsif action_name === 'download'
        @theme = Theme.where("title_url = ?", id.downcase.parameterize).first
      elsif action_name != 'upload'
        @theme = Theme.where("title_url = ?", id.downcase.parameterize).includes(:comments).first
      end
      unless @theme || action_name === 'upload'
        flash[:alert] = "There Is No Theme By That Name"
        redirect_to root_path
      end
    else
      render json:{message:"No ID parameter was provided"}, status: :bad_request
    end
  end

  def is_admin
    unless current_user.try(:admin?)
      flash[:alert] = "\"I'm sorry Dave, I'm afraid I can't let you do that\""
      redirect_to root_path
    end
  end

end