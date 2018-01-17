require 'carrierwave'
class Theme < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable

  belongs_to :user
  has_many :comments, :dependent => :destroy
  has_many :photos, as: :photoable, dependent: :delete_all
  accepts_nested_attributes_for :photos

  before_create :validate_theme_url
  validates :title, :presence => true, :uniqueness => { :case_sensitive => false }

  def self.uploadPhoto(theme,s3)
    bucket = Rails.application.secrets.aws_bucket
    photo_path = "#{Rails.root}/public#{theme.photos.first.photo.url}"
    upload_url = "#{theme.photos.first.photo.url}"
    upload_url[0] = ""
    upload = s3.bucket(bucket).object(upload_url)
    upload.upload_file(photo_path)
    urls = theme.photo_urls
    url = "https://cdn.staplethemes.com#{upload.public_url.to_s.split('.com')[-1]}"
    urls << url
    theme.photo_urls = urls
    theme.save
  end

end
