class UserMailer < ApplicationMailer
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
        attachments.inline['logo.png'] =  File.read(Rails.root.join("app/assets/images/staple_themes_logo.png"))
        attachments.inline['facebook.png'] = File.read(Rails.root.join("app/assets/images/facebook.png"))
        attachments.inline['twitter.png'] = File.read(Rails.root.join("app/assets/images/twitter.png"))
        @order = order
        @user = user
        @themes = themes
        mail(to: @user.email, from:"noreply@staplethemes.com", subject: "Your Staple Themes Order Has Been Confirmed")
    end
end
