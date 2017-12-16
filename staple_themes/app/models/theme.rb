class Theme < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable

  belongs_to :user
  has_many :comments, :dependent => :destroy
  has_many :photos, as: :photoable, dependent: :delete_all
  accepts_nested_attributes_for :photos
end
