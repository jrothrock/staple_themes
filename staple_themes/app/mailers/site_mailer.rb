class SiteMailer < ApplicationMailer
    def contact(message)
        @message = message
        @type = message.type
        mail(to: "staplethemes@gmail.com", from: "#{message.email}", subject: "Contact Form From #{message.name}")
    end 

    def hosting(message)
        @message = message
        mail(to: "staplethemes@gmail.com", from: "info@staplethemes.com", subject: "Hosting request for #{message.domain}")
    end
end
