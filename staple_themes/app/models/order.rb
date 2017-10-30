class Order < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable

  has_many :themes
  belongs_to :user

  before_create do
    self.uuid = setUUID if self.uuid.blank?
  end

  private 

  def setUUID
    begin 
      uuid = SecureRandom.hex(5)
      uuid[0] = '' # bring string down to 9 characters
      if(Order.unscoped.where("uuid = ?", uuid).any?) then raise 'Go buy some lotto tickets, order UUID has a duplicate!' end
      return uuid
      rescue
        retry
    end
  end

end
