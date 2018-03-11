class PostsController < ApplicationController
    before_action :authenticate_user!, only: [:new, :edit, :update, :destroy, :likes]
    before_action :is_admin, only: [:new, :edit, :update, :destroy]
    before_action :find_post, only: [:edit, :update, :show, :destroy, :likes]

    # Index action to render all posts
    def index
        if params[:category]
            @category = true
            @posts = Post.where("category = ?", params[:category]).as_json
        else
            @posts = Post.all.as_json
        end
        if current_user
            @posts.map do |post|
                post.merge!("liked"=>post['likes'].include?(current_user.id.to_s))
            end
        end
    end

    # New action for creating post
    def new
        @post = Post.new
    end

    # Create action saves the post into database
    def create
        @post = Post.new
        @post.title = params[:post][:title]
        @post.title_url = @post.title.downcase.parameterize
        @post.body = params[:post][:body]
        @post.category = params[:post][:category]
        @post.user_id = current_user.id
        if @post.save
        flash[:notice] = "Successfully created post!"
        redirect_to post_path(@post.title_url)
        else
        flash[:alert] = "Error creating new post!"
        render :new
        end
    end

    # Edit action retrives the post and renders the edit page
    def edit
    end

    # Update action updates the post with the new information
    def update
        if @post.update_attributes(post_params)
        flash[:notice] = "Successfully updated post!"
        redirect_to post_path(@posts)
        else
        flash[:alert] = "Error updating post!"
        render :edit
        end
    end

    # The show action renders the individual post after retrieving the the id
    def show        
        if @post && current_user && @post['likes'].include?(current_user.id.to_s)
            @post.merge!("liked" => true)
        end
    end

    # The destroy action removes the post permanently from the database
    def destroy
        if @post.destroy
            flash[:notice] = "Successfully deleted post!"
            redirect_to posts_path
        else
            flash[:alert] = "Error updating post!"
        end
    end

    def likes
        if @post.likes.include?(current_user.id.to_s)        
            @post.likes_count -= 1
            @post.likes -= [current_user.id.to_s]
            @post.save
            render json:{delete:true, id: @post.title_url, count: @post.likes_count}, status: :ok
        else
            @post.likes_count += 1
            @post.likes << current_user.id.to_s
            @post.save
            render json:{delete:false, id: @post.title_url, count: @post.likes_count}, status: :ok
        end
    end

    private

    def post_params
        params.require(:post).permit(:title, :body, :category)
    end

    def find_post
        if action_name === 'show'
            @post = Post.where("title_url = ?", params[:id]).first.as_json({:include => {:comments => {:include => :user}}})
        else
            @post = Post.where("title_url = ?", params[:id]).first
        end
        unless @post
            flash[:alert] = "There Is No Post By That Name"
            redirect_to posts_path
        end
    end

    def is_admin
        unless current_user.try(:admin?)
            flash[:alert] = "\"I'm sorry Dave, I'm afraid I can't let you do that\""
            redirect_to root_path
        end
    end
end
