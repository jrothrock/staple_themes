import "card/dist/jquery.card.js";
import "card/dist/card.css";
var themeAppCheckout = {
    paypalLoaded:false,
    paypalButton(){
        if(!this.paypalLoaded){
            this.paypalLoaded = true;
            let env = location.host === "localhost:3000" ? 'sandbox' : 'production'
            paypal.Button.render({
            
                env: env, // Optional: specify 'sandbox' environment
            
                payment: function(resolve, reject) {
                    
                    var CREATE_PAYMENT_URL = `${location.origin}/checkout/paypal`;
                        
                    return paypal.request.post(CREATE_PAYMENT_URL)
                        .then(function(data) { 
                            resolve(data.paymentID);
                        })
                        .catch(function(err) {
                            reject(err); 
                        });
                },
                style:{
                color:"silver",
                shape:"rect",
                size:"small"
                },
                onAuthorize: function(data) {
                
                    // Note: you can display a confirmation page before executing
                    
                    var EXECUTE_PAYMENT_URL = `${location.origin}/checkout`;

                    return paypal.request.post(EXECUTE_PAYMENT_URL,
                            { paypal:true, paymentID: data.paymentID, payerID: data.payerID})
                            
                        .then(function(data) { 
                            localStorage.removeItem('_staple_themes_cart')
                            Turbolinks.visit(`/users/${data.username}/purchases/`, { action: "replace" })
                        })
                        .catch(function(err) {
                            console.log('it failed');
                        });
                },
                onCancel: function(data, actions) {
                    console.log('canceled');
                    // component.paying = false;
                    // component.location = 'payment';
                    // component._location.go('/cart#payment');
                    // $(`#payment-content`).slideDown();
                    // $(`#processing-content`).slideUp();
                }

            }, '#paypal-button');
        }
    },
    createCCForm(){
        $('form').card({
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '.credit-card-form-js', // *required*

            // all of the other options from above
        });
    },
    watchCCButton(){
        $(`#credit-card-button`).on('click', function(){
            $(`#credit-card-form`).css({'display':'block'});
            let key = location.host === "localhost:3000" ? "pk_test_V6S48hbNKZVYxW57qLsBTY8e" : "pk_live_PfBjJGWp1M62Bg20RAyBOGXs"
            Stripe.setPublishableKey(key);
            $(`#order-submit`).on('click', (e)=>{
                $(`#order-submit`).addClass('disabled');
                e.preventDefault(); themeAppCheckout.proccessStripe()
            });
        });
    },
    watchDiscount(){
        $(`#discount-code-button`).on('click',function(){
            let code = $(`#discount-code`).val()
            let cart = localStorage.getItem('_staple_themes_cart');
            $.ajax({
                url: `${location.origin}/orders/${cart}/discount`,
                data:{code:code},
                type: 'POST',
                success: (data) => {
                    $('#total-checkout').text(data.order.discounted_total)
                    $('#total-checkout-discounted').text(data.order.total)
                },
                error: (error)=> {
                    console.log(error);
                    if(error.status === 404){
                        Materialize.toast('No Code Found By That Name', 4200, 'failure-rounded')
                    } else if(error.status === 400 && error.responseJSON.expired){
                        Materialize.toast('That Code Has Expired', 4200, 'failure-rounded')
                    } else if(error.status === 400 && error.responseJSON.discounted){
                        Materialize.toast('Only One Discount Can Be Applied At A Time', 4200, 'failure-rounded')
                    }
                }
            });
        })
    },
    proccessStripe(){
        Stripe.card.createToken({
            number:$('#number').val().replace(/ /g,''),
            cvc:$('#security').val(),
            exp_month:$('#expiry').val().replace(/ /g,"").split('/')[0],
            exp_year:$('#expiry').val().replace(/ /g,"").split('/')[1],
            name:$('#holder').val(),
            address_zip:$('#zip').val()
        }, function stripeResponseHandler(status, response) {
            if (response.error) { // Problem!
                // Show the errors on the form
                console.log(response)
               
                $('#name, #number, #expiry, #cvc').parent().addClass('error');
                Materialize.toast('Failed To Process Card. Please Check Inputs And Try Again', 4200, 'failure-rounded')
                $(`#order-submit`).removeClass('disabled');
            } else { // Token was created!
                // Get the token ID:
                console.log()
                // var token = response.id;
                // component.token = token;

                themeAppCheckout.proccessStripeServer(response.id);
                // Insert the token into the form so it gets submitted to the server:
                // $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // Submit the form:
                // $form.get(0).submit();
            }
        });
    },
    proccessStripeServer(token){
        $.ajax({
                    url: `${location.origin}/checkout`,
                    data:{paypal:false,token:token},
                    dataType:'json',
                    type: 'POST',
                    success: (data) => {
                      console.log(data);  
                      localStorage.removeItem('_staple_themes_cart')
                      Turbolinks.visit(`/users/${data.username}/purchases/`, { action: "replace" })
                    },
                    error: (error)=> {
                        $(this).prop('disabled', false);
                        console.log(error);
                    }
                });
    },
    init(){
        setTimeout(()=>{
            themeAppCheckout.createCCForm();
            themeAppCheckout.paypalButton();
            themeAppCheckout.watchCCButton();
            themeAppCheckout.watchDiscount();
        },1)
    }
}

$(document).on('turbolinks:load', ()=>{themeAppCheckout.init()});