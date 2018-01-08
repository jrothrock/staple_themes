class SiteMailer < ApplicationMailer
    def contact(message)
        @message = message
        if message.type.to_i === 1
            @type = 'General Inquiry'
        elsif message.type.to_i === 2
            @type = 'Sales Inquiry'
        elsif message.type.to_i === 3
            @type = 'Support'
        else
            @type = 'Bug Report'
        end
        mail(to: "staplethemes@gmail.com", from: "#{message.email}", subject: "Contact Form From #{message.name}")
    end 
end
