class CreateComments < ActiveRecord::Migration[5.1]
  def change
    drop_table :comments
    create_table :comments do |t|
      t.references :user, index: true
      t.references :theme, index: true
      t.text :content

      t.timestamps null: false
    end
    add_foreign_key :comments, :users
    add_foreign_key :comments, :themes
  end
end
