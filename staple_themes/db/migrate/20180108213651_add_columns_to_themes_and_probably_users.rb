class AddColumnsToThemesAndProbablyUsers < ActiveRecord::Migration[5.1]
  def change
    add_column :themes, :download_url, :string, null:false, default: ''
    add_column :themes, :download_name, :string, null:false, default: ''
    add_column :themes, :title_url, :string, null:false, default: ''
    remove_column :themes, :downloads, :integer
    add_column :themes, :downloads, :integer, null:false, default:0
    add_column :themes, :photo_urls, :text, array:true, default: []
    add_column :themes, :upload_status, :integer, null:false, default: 0
  end
end