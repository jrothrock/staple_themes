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
            $(this).addClass('disabled')
            $(`#credit-card-form`).css({'display':'block'});
            let key = location.host === "localhost:3000" ? "pk_test_V6S48hbNKZVYxW57qLsBTY8e" : "pk_live_PfBjJGWp1M62Bg20RAyBOGXs"
            Stripe.setPublishableKey(key);
            $(`#order-submit`).on('click', (e)=>{e.preventDefault(); themeAppCheckout.proccessStripe()});
        });
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
                $(this).prop('disabled', false);
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
        },1)
    }
}

$(document).on('turbolinks:load', ()=>{themeAppCheckout.init()});