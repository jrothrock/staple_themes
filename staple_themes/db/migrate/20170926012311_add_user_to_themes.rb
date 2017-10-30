class AddUserToThemes < ActiveRecord::Migration[5.0]
  def change
    add_reference :themes, :user, foreign_key: true
  end
end
