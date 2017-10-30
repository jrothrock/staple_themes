class Comment < ApplicationRecord
    belongs_to :commentable, polymorphic: true
    # has_many :comments, dependent: :delete_all
    belongs_to :parent, :class_name => "Comment", :foreign_key => "parent_uuid", primary_key: :uuid
    has_many :replies, -> { select(App.getGoodColumns('comments',true)) }, :class_name => "Comment", :foreign_key => "parent_uuid", dependent: :delete_all, primary_key: :uuid

    before_create do
        self.uuid = setUUID if self.uuid.blank?
    end

    private 

    def setUUID
        begin 
            uuid = SecureRandom.hex(5)
            uuid[0] = '' # bring string down to 9 characters
            if(Comment.unscoped.where("uuid = ?", uuid).any?) then raise 'Go buy some lotto tickets, UUID has a duplicate!' end
            return uuid
        rescue
            retry
        end
    end
end