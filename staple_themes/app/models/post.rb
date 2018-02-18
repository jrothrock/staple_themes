class Post < ApplicationRecord
    validates :title, :presence => true, :uniqueness => { :case_sensitive => false }
    has_many :comments, as: :commentable, dependent: :delete_all
    belongs_to :user
end
