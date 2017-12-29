class AddSomeColumnsToUsersAndThemeProbablyOtherTablesToo < ActiveRecord::Migration[5.1]
  def change
    add_column :users, :uuid, :string, null:false, default: ''
    add_column :themes, :excerpt, :string
    remove_column :orders, :type, :integer
    remove_column :orders, :theme_id, :integer
    add_column :orders, :themes, :text, array:true, null:false, default: []
    add_column :orders, :purchased_at, :datetime
    add_column :orders, :uuid, :string, null:false, default: ''
    add_column :orders, :licenses, :text, array:true, null:false, default: []
    remove_column :themes, :price, :decimal, precision: 8, scale: 2
    remove_column :themes, :sale_price, :decimal, precision: 8, scale: 2
    add_column :themes, :single_price, :decimal, precision: 8, scale: 2
    add_column :themes, :single_sale_price, :decimal, precision: 8, scale: 2
    add_column :themes, :multi_price, :decimal, precision: 8, scale: 2
    add_column :themes, :multi_sale_price, :decimal, precision: 8, scale: 2
    add_column :themes, :purchases, :integer, default: 0, null:false
  end
end
