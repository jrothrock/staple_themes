class HomeController < ApplicationController
  def index
    @themes = $redis.get("themes_home")
    if @themes.nil?
      @themes = Theme.where("upload_status = 1").all.limit(3)
      $redis.set("themes_home",@themes.to_json)
      $redis.rpush("all_keys", "themes_home")
    else
      @themes = JSON.parse(@themes)
    end
  end
end