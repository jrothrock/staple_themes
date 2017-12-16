class AddAndRemoveColumnsFromTheme < ActiveRecord::Migration[5.1]
  def change
    add_column :themes, :purchase_type, :integer, default:1
    add_column :themes, :purchase_url, :string
    add_column :themes, :downloads, :integer
    remove_column :themes, :average_rating, :integer, default:100
    add_column :themes, :average_rating, :decimal, default: 0.0, precision: 8, scale: 2
    drop_table :ratings
    add_column :comments, :rating, :integer, default:0
  end
end
