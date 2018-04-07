class CheckoutController < ApplicationController
    protect_from_forgery :except => [:update, :paypal]
    # skip_before_action :verify_authenticity_token, :only => [:update]
    before_action :authenticate_user!, :only => [:update]
    include PayPal::SDK::REST
    include PayPal::SDK::Core::Logging
    def show
        @order_checkout = ApplicationRecord::Order.where("uuid = ?", session[:order_id]).first
        unless @order
            flash[:alert] = "You don't have an order started"
            redirect_to root_path
        end
    end

    def update
    @order = ApplicationRecord::Order.where("uuid = ?", session[:order_id]).first
    if(@order)
        themes = Theme.where("id IN (?)", @order.themes)
        # @order.email = current_user.email ? current_user.email : order.email
        @order.status = 2
        ApplicationRecord::Order.transaction do
            begin
                if params[:paypal] === true || params[:paypal] === "true"
                    if !params[:paymentID] || !params[:payerID]
                        render json:{message:"The paymentID and payerID param are required"}, status: :bad_request
                        return false
                    end
                    begin
                        mode = Rails.env.production? ? 'live' : 'sandbox'
                        PayPal::SDK::REST.set_config(
                            :mode => mode, # "sandbox" or "live"
                            :client_id => Rails.application.secrets.paypal_id,
                            :client_secret => Rails.application.secrets.paypal_secret
                        )
                        payment = Payment.find(params[:paymentID])
                        if payment.execute( :payer_id => params[:payerID] )  # return true or false
                            puts "Payment[#{payment.id}] executed successfully"
                        else
                            raise "payment execution failed"
                        end
                        @order.paypal_payment_id = payment.id
                        @order.save
                    rescue Exception => e
                        Rails.logger.info(e.inspect)
                        Rails.logger.info(e.backtrace)
                        Rails.logger.info(payment.error.inspect)
                        ExceptionNotifier.notify_exception(e,
                                    :env => request.env, :data => {:message => "Paypal Order Payment Has Failed. Error: #{e.inspect}, #{e.backtrace}, Payment:#{payment.error.inspect}"})
                        render json:{paylpal_fail:true, message:'paypal error', error:payment.error}, status: :internal_server_error
                        raise ActiveRecord::Rollback
                    end
                else
                    Stripe.api_key =  Rails.application.secrets.stripe
                    puts Stripe.api_key
                    puts Stripe::Charge.as_json
                    # Get the credit card details submitted by the form
                    token = params[:token]
                    amount = ((@order.discounted ? @order.discounted_total.to_f : @order.total.to_f ) * 100).to_i

                    # Create a charge: this will charge the user's card
                    begin
                        charge = Stripe::Charge.create(
                            :amount => ((@order.discounted ? @order.discounted_total.to_f : @order.total.to_f)*100.00).to_i, # Amount in cents
                            :currency => "usd",
                            :source => token,
                            :description => `Charge for order #{@order.uuid}`,
                            :transfer_group => "ORDER_#{@order.uuid}",
                        )
                    rescue Stripe::CardError => e
                        Rails.logger.info(e)
                        render json:{card_fail:true, message:'card error'}, status: :internal_server_error
                        raise ActiveRecord::Rollback
                        return false
                    rescue => e
                        Rails.logger.info(e)
                        ExceptionNotifier.notify_exception(e,
                                    :env => request.env, :data => {:message => "Paypal Stripe Payment Has Failed. Error: #{e.inspect}, #{e.backtrace}"})
                        render json:{message:"failed in the stripe payment"}, status: :internal_server_error
                        raise ActiveRecord::Rollback
                        return false
                    end
                    @order.stripe_payment_id = charge.id
                    @order.save
                end
                themes.each do |theme|
                    theme.purchasers[current_user.uuid] = 1
                    theme.purchases += 1
                    theme.save
                end
                session[:order_id] = nil
                App.purge_cache
                render json:{order:@order.as_json, username:current_user.username}, status: :ok
                UserMailer.order_email(current_user, @order, themes).deliver
            rescue => e
                # render json:{}, status: :internal_server_error
                puts e
                ExceptionNotifier.notify_exception(e,
                    :env => request.env, :data => {:message => "Order Has Failed. Error: #{e.inspect}, #{e.backtrace}"})
                if Rails.env.production?
                    # render json:{error:e}, status: :internal_server_error
                else
                    # render json:{error:e, backtrace: e.backtrace}, status: :internal_server_error
                end
            end
        end
    else
        render json:{message:"Order not found"}, status: :not_found
    end
    end

    def paypal
        if(session[:order_id])
            order = ApplicationRecord::Order.where("uuid = ?", session[:order_id]).first
            if order
                themes = Theme.where("id in (?)", order.themes)
                items = []
                themes.each_with_index do |theme,index|
                    item_hash = {}
                    item_hash["name"] = theme.title
                    item_hash["description"] = "#{order.licenses[index] === 1 ? 'Single' : 'Multi'} Site license for the #{theme.title} Wordpress Theme"
                    license = order.licenses[index]
                    if license.to_i === 1
                        item_hash["price"] = theme.single_sale_price ? theme.single_sale_price : theme.single_price
                    else
                        item_hash["price"] = theme.multi_sale_price ? theme.multi_sale_price : theme.multi_price
                    end
                    item_hash['currency'] = "USD"
                    item_hash['tax'] = "0.00"
                    item_hash['quantity'] = 1
                    items << item_hash
                end

                if order.discounted
                    item_hash = {}
                    item_hash["name"] = "Discount"
                    item_hash["description"] = "Discount using the code: #{order.discount_code}"
                    item_hash["price"] = order.discounted_total - order.total
                    item_hash['currency'] = "USD"
                    item_hash['tax'] = "0.00"
                    item_hash['quantity'] = 1
                    items << item_hash
                end

                mode = Rails.env.production? ? 'live' : 'sandbox'
                PayPal::SDK::REST.set_config(
                    :mode => mode, # "sandbox" or "live"
                    :client_id => Rails.application.secrets.paypal_id,
                    :client_secret => Rails.application.secrets.paypal_secret
                )

                @payment = Payment.new({
                    :intent =>  "sale",

                    # ###Payer
                    # A resource representing a Payer that funds a payment
                    # Payment Method as 'paypal'
                    :payer =>  {
                        :payment_method =>  "paypal" },

                    # ###Redirect URLs
                    :redirect_urls => {
                        :return_url => "https://staplethemes.com/checkout",
                        :cancel_url => "https://staplethemes.com" },

                    # ###Transaction
                    # A transaction defines the contract of a
                    # payment - what is the payment for and who
                    # is fulfilling it.
                    :transactions =>  [{

                        # Item List
                        :item_list => {
                            :items => items
                        },

                        # ###Amount
                        # Let's you specify a payment amount.
                        :amount =>  {
                            :total =>  (order.discounted ? order.discounted_total.to_s : order.total.to_s),
                            :currency =>  "USD",
                            :details =>
                                {
                                    :subtotal => (order.discounted ? order.discounted_total.to_s : order.total.to_s),
                                    :shipping => "0.00",
                                    :tax => "0.00",
                                } 
                        },

                        :description =>  "Your Staple Themes order." 
                        
                    }]
                })

                # Create Payment and return status
                if @payment.create
                # Redirect the user to given approval url
                    render json:{paymentID:@payment.id}, status: :ok
                    # @redirect_url = @payment.links.find{|v| v.rel == "approval_url" }.href
                    # logger.info "Payment[#{@payment.id}]"
                    # logger.info "Redirect: #{@redirect_url}"
                else
                    logger.error @payment.error.inspect
                    render json:{}, status: :internal_server_error
                end
            else
                render json:{message:"No order was found"}, status: :not_found
            end
        else
            render json:{message:"No order was found"}, status: :not_found
        end
    end
end