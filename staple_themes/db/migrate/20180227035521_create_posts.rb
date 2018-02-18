class CreatePosts < ActiveRecord::Migration[5.1]
  def change
    create_table :posts do |t|
      t.string :title
      t.text :body
      t.string :title_url
      t.string :category
      t.integer :comment_count, null:false, default: 0
      t.integer :likes_count, null:false, default: 0
      t.integer :user_id
      t.text :likes, array:true, null:false, default: []
      t.timestamps
    end
    remove_column :comments, :theme_id, :integer
    add_column :comments, :commentable_type, :string
    add_column :comments, :commentable_id, :integer
    add_index :comments, [:commentable_type, :commentable_id]
    add_index :posts, :user_id
  end
end
