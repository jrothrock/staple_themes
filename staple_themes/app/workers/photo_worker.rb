class PhotoWorker
	include Sidekiq::Worker
    def perform(id)
        theme = Theme.find_by_id(id)
        key = Rails.application.secrets.aws_access_key_id
		secret =  Rails.application.secrets.aws_secret_access_key
		credentials = Aws::Credentials.new(key, secret)
		s3 = Aws::S3::Resource.new(region: 'us-west-2', credentials: credentials)
        Theme.uploadPhoto(theme,s3)
        theme.update({upload_status:1})
        App.purge_cache
    end
end