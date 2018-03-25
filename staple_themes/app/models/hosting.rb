class Hosting < ApplicationRecord
    before_create :setPhoto
    before_create :setUUID
    private

    def setPhoto
        if self.plan === 1
            self.photo_urls = ["https://cdn.staplethemes.com/images/hosting/materialize_standard_hosting_box.png"]
        elsif self.plan === 2
            self.photo_urls = ["https://cdn.staplethemes.com/images/hosting/materialize_growth_hosting_box.png"]
        else
            self.photo_urls = ["https://cdn.staplethemes.com/images/hosting/materialize_scaling_hosting_box.png"]
        end

    end

    def setUUID
      begin 
      uuid = SecureRandom.hex(5)
      uuid[0] = '' # bring string down to 9 characters, 68B possibilitis
      if(Hosting.unscoped.where("uuid = ?", uuid).any?) then raise 'Go buy some lotto tickets, hosting UUID has a duplicate!' end
      return uuid
      rescue
          retry
      end
  end
end