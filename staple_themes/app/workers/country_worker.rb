class CountryWorker
	include Sidekiq::Worker
    def perform(ip, id)
        countries = ["AT", "BE", "BG", "HR", "CY", "CZ", "DK", "EE", "FI", "FR", "DE", "GR", "HU", "IE", "IT", "LV", "LT", "LU", "MT", "NL", "PL", "PT", "RO", "SK", "SI", "ES", "SE", "GB"]
        geo = Geokit::Geocoders::MultiGeocoder.geocode(ip)
        if geo && geo.success
            $redis.set("country_set_id_#{id}",countries.include?(geo.country_code))
        end
    end
end