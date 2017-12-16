class HomeController < ApplicationController
  def index
    @themes = Theme.all.limit(10).includes(:photos)
  end
end