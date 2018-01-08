class User < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable
  attr_accessor :login

  devise :database_authenticatable, :registerable,
         :recoverable, :rememberable, :trackable, :validatable

  validates :username, :presence => true, :uniqueness => { :case_sensitive => false }
  validate :validate_username

  has_many :themes
  # has_many :themes, :dependent => :destroy
  has_many :purchases
  has_many :orders
  has_many :comments, :dependent => :destroy

  before_create do
    self.uuid = setUUID if self.uuid.blank?
  end

  def self.find_for_database_authentication(warden_conditions)
      conditions = warden_conditions.dup
      if login = conditions.delete(:login)
        where(conditions.to_h).where(["lower(username) = :value OR lower(email) = :value", { :value => login.downcase }]).first
      elsif conditions.has_key?(:username) || conditions.has_key?(:email)
        conditions[:email].downcase! if conditions[:email]
        where(conditions.to_h).first
      end
  end

  def validate_username
    if User.where(email: username).exists?
      errors.add(:username, :invalid)
    end
  end

  def setUUID
      begin 
      uuid = SecureRandom.hex(5)
      uuid[0] = '' # bring string down to 9 characters, 68B possibilitis
      if(Photo.unscoped.where("uuid = ?", uuid).any?) then raise 'Go buy some lotto tickets, order UUID has a duplicate!' end
      return uuid
      rescue
          retry
      end
  end
end
