class CreateDiscounts < ActiveRecord::Migration[5.1]
  def change
    create_table :discounts do |t|
      t.string :name, null: false, default: ""
      t.string :code, null: false, default: ""
      t.decimal :amount, precision: 8, scale: 2
      t.boolean :expired, null:false, default:true
      t.integer :uses, null:false, default: 0
    end
    add_column :orders, :discounted, :boolean, null:false, default: false
    add_column :orders, :discount, :decimal, precision: 8, scale: 2
    add_column :orders, :discount_total, :decimal, precision: 8, scale: 2
    add_column :orders, :discounted_total, :decimal, precision: 8, scale: 2
    add_column :orders, :discount_code, :string
  end
end
