class App < ApplicationRecord
    def self.purge_cache
        if $redis.exists("all_keys") 
            $redis.lrange("all_keys",0,-1).each do |key|
                $redis.del(key)
            end
            $redis.del("all_keys")
        end
    end
end