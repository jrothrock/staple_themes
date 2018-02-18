class CommentsController < ApplicationController

    before_action :set_item, only: [:create]

    def index
    end
    def new
    end
    def create
        if @item
            comment = @item.comments.new
            comment.content = params['content']
            comment.user = current_user
            comment.rating = params['rating'].to_i
            if @item.class.to_s === "Theme"
                total_rating = @item.average_rating * @item.ratings_count.to_f
                @item.average_rating = ((total_rating + params[:rating].to_f) / (@item.ratings_count.to_f + 1)).to_f
                @item.ratings_count += 1
            else
                @item.comment_count += 1
            end
            if comment.save && @item.save
                App.purge_cache
                render json:{comment:comment, user:current_user.username, user_id: current_user.id}, status: :ok
            else 
                logger.debug comment.errors.full_messages
                logger.debug @item.errors.full_messages
                render json:{}, status: :internal_server_error
            end
        end
    end
    def show
    end
    def update
    end
    def destroy
        comment = Comment.where("id = ?", params[:id]).first
        if comment
            if comment.user_id === current_user.id
                if comment.commentable_type === 'Theme'
                    theme = Theme.where("id = ?", comment.commentable_id).first
                    total_rating = theme.average_rating * theme.ratings_count.to_f
                    theme.average_rating = ((total_rating - comment.rating.to_f) / (theme.ratings_count.to_f - 1)).to_f
                    theme.ratings_count -= 1
                    theme.save
                else
                    post = Post.where("id = ?", comment.commentable_id).first
                    post.comment_count -= 1
                    post.save
                end
                comment.destroy
                App.purge_cache
                render json:{}, status: :ok
            else
                render json:{message:"You don't have permission to do that"}, status: :unauthorized
            end
        else
            render json:{message:"not found"}, status: :not_found
        end
    end

    private 

    def set_item
        type = "Item"
        if request.original_url.include?("/blog/")
            @item = Post.where("title_url = ?", params[:post_id]).first
            type = "Post"
        else
            @item = Theme.where("title_url = ?", params[:theme_id]).first
            type = "Tost"
        end
        unless @item
            flash[:alert] = "There Is No #{type} By That Name"
            render json:{message:"Not found"}, status: :not_found
        end
    end
end