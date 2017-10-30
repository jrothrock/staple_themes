class Changepurchasesnametoorders < ActiveRecord::Migration[5.0]
  def change
    rename_table :purchases, :orders
  end
end
