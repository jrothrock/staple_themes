class SiteMailer < ApplicationMailer
    def contact(message)
        @message = message
        @type = message.type
        mail(to: "staplethemes@gmail.com", from: "#{message.email}", subject: "Contact Form From #{message.name}")
    end 
end
