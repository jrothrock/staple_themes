class UserMailer < ApplicationMailer
    def reset_email(user)
        urls = ['https://cdn.staplethemes.com/images/staple_themes_logo.png','https://cdn.staplethemes.com/images/facebook.png','https://cdn.staplethemes.com/images/twitter.png']
        names = ['logo.png','facebook.png','twitter.png']
        3.times do |x|
            download = open(urls[x])
            file = Tempfile.new(['hello', '.png'])
            IO.copy_stream(download, file.path)
            attachments.inline[names[x]] = File.read(file.path)
            download.close
        end
        @user = user
        @production = Rails.env.production?
        mail(to: @user.email, from:"noreply@staplethemes.com", subject: 'Reset Password')
    end
    def order_email(user,order,themes)
        themes.each_with_index do |theme,index|
            download = open(theme["photo_urls"][0])
            file = Tempfile.new(['hello', '.png'])
            IO.copy_stream(download, file.path)
            puts 'before inline'
            attachments.inline["theme_#{theme.title.downcase}.png"] = File.read(file.path)
            puts 'after inline'
            download.close
        end
        urls = ['https://cdn.staplethemes.com/images/staple_themes_logo.png','https://cdn.staplethemes.com/images/facebook.png','https://cdn.staplethemes.com/images/twitter.png']
        names = ['logo.png','facebook.png','twitter.png']
        3.times do |x|
            download = open(urls[x])
            file = Tempfile.new(['hello', '.png'])
            IO.copy_stream(download, file.path)
            attachments.inline[names[x]] = File.read(file.path)
            download.close
        end
        @order = order
        @user = user
        @themes = themes
        mail(to: @user.email, from:"noreply@staplethemes.com", subject: "Your Staple Themes Order Has Been Confirmed")
    end
end
