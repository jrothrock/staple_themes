class CommentsController < ApplicationController

    before_action :set_theme, only: [:create]

    def index
    end
    def new
    end
    def create
        if @theme
            comment = @theme.comments.new
            comment.content = params['content']
            comment.user = current_user
            comment.rating = params['rating'].to_i
            total_rating = @theme.average_rating * @theme.ratings_count.to_f
            @theme.average_rating = ((total_rating + params[:rating].to_f) / (@theme.ratings_count.to_f + 1)).to_f
            @theme.ratings_count += 1
            if comment.save && @theme.save
                App.purge_cache
                render json:{}, status: :ok
            else 
                render json:{}, status: :internal_server_error
            end
        end
    end
    def show
    end
    def update
    end
    def destroy
    end

    private 

    def set_theme
        @theme = Theme.where("title_url = ?", params[:theme_id]).first
        puts @theme
        unless @theme
            flash[:alert] = "There Is No Theme By That Name"
        end
    end
end