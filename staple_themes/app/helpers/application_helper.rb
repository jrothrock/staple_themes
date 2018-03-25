module ApplicationHelper
    def alert_for(flash_type)
        {
            success: 'alert-success text-center',
            error: 'alert-danger text-center',
            alert: 'alert-danger text-center',
            notice: 'alert-info text-center'
        }[flash_type.to_sym] || flash_type.to_s
    end

    def form_image_select(post)
        return image_tag post.image.url(:medium),
                     id: 'image-preview',
                     class: 'img-responsive' if post.image.exists?
        image_tag 'placeholder.jpg', id: 'image-preview', class: 'img-responsive'
    end
    
    def plan_name(plan)
        {
            "1": 'Standard',
            "2": "Growth",
            "3": "Scaling"
        }[plan.to_s]
    end

    def host_price(payment_type, type)
        if payment_type === 1 && type === 1
            return "$24.99"
        elsif payment_type === 2 && type === 1
            return "$239.88"
        elsif payment_type === 1 && type === 2
            return "$49.99"
        elsif payment_type === 2 && type === 2
            return "$479.88"
        elsif payment_type === 1 && type === 3
            return "$74.99"
        else
            return "$719.88"
        end
    end
end
