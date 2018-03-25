class CreateHostings < ActiveRecord::Migration[5.1]
  def change
    create_table :hostings do |t|
      t.integer :user_id
      t.integer :plan
      t.string :website
      t.integer :status
      t.integer :payment_type
      t.string :stripe_sub
      t.string :uuid
      t.timestamps
    end
    add_column :orders, :plans, :text, array:true, default: []
    add_column :orders, :photo_urls, :text, array:true, default:[]
  end
end
