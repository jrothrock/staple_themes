require 'carrierwave'
class Theme < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable

  belongs_to :user
  has_many :comments, as: :commentable, dependent: :delete_all
  has_many :photos, as: :photoable, dependent: :delete_all
  accepts_nested_attributes_for :photos

  validates :title, :presence => true, :uniqueness => { :case_sensitive => false }

  def self.uploadPhoto(theme,s3)
    bucket = Rails.application.secrets.aws_bucket
    begin
      if Rails.env.production?
        photo_path = "#{Rails.root.to_s.split("releases")[0]}current/public#{theme.photos.first.photo.url}"
      else
        photo_path = "#{Rails.root}/public#{theme.photos.first.photo.url}"
      end
      upload_url = "#{theme.photos.first.photo.url}"
      upload_url[0] = ""
      upload = s3.bucket(bucket).object(upload_url)
      upload.upload_file(photo_path)
      urls = theme.photo_urls
      url = "https://cdn.staplethemes.com#{upload.public_url.to_s.split('.com')[-1]}"
      urls << url
      theme.photo_urls = urls
      theme.save
    rescue => e
      puts e
    end
  end
end
