class CreatePurchases < ActiveRecord::Migration[5.0]
  def change
    create_table :purchases do |t|
      t.integer  "status",                                            default: 1,     null: false
      t.integer "type", default: 1, null:false
      t.references :user, foreign_key: true
      t.references :theme, foreign_key: true
      t.timestamps null: false
      t.decimal  "total",                                 precision: 8, scale: 2
      t.decimal  "subtotal",                                 precision: 8, scale: 2
      t.decimal  "tax",                                 precision: 8, scale: 2
      t.decimal  "tax_rate",                  precision: 8, scale: 4, default: "0.0", null: false
      t.string   "paid_with",                                         default: ""
      t.string   "stripe_payment_id",                                 default: ""
      t.string   "paypal_payment_id",                                 default: ""
    end
  end
end
