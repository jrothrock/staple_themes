/* eslint no-console:0 */
// This file is automatically compiled by Webpack, along with any other files
// present in this directory. You're encouraged to place your actual application logic in
// a relevant structure within app/javascript and only use these pack files to reference
// that code so it'll be compiled.
//
// To reference this file, add <%= javascript_pack_tag 'application' %> to the appropriate
// layout file, like app/views/layouts/application.html.erb
import Turbolinks from 'turbolinks';
import "raty-js/lib/jquery.raty.js";
import "raty-js/lib/jquery.raty.css";
Turbolinks.start();

var themeApp = {
    userProfileHover(){
        $("#profile-hover").dropdown({ hover: true, inDuration: 300, outDuration: 225, alignment: 'left', constrain_width: false, belowOrigin: true });
        $("#profile-hover").on('click', (e)=>{
            e.preventDefault();
            $("#profile-hover").trigger('hover');
        })
    },
    // I actually don't know if this is necessary. However, I'll keep it here anyways.
    checkCart(){
        let cart = localStorage.getItem('_staple_themes_cart');
        if(cart){
            $.ajax({
                url: `${location.origin}/orders/${String(cart)}`,
                type: 'GET',
                success: (data) => {
                    console.log(data);
                },
                error: (error)=> {
                    console.log(error);
                }
            });
        }
    },
    watchThemeModal(){
        // watch open
        $('.modal-trigger').on('click', function(){
            $('#add-to-cart').unbind('click');
            $('.modal').modal('open');
            let modal = $(this).data('target');
            let theme = $(this).data('theme');
            if($(`#${modal}`).length) $(`#${modal}`).data('theme', theme);
            $(`#license-modal`).text(`${$(this).data('title')} License Types`);
            $(`#single-modal`).text(`${$(this).data('single-text')}`);
            $(`#multi-modal`).text(`${$(this).data('multi-text')}`);
            themeApp.addToCart();
        })
        // watch close
        $('#close-modal').on('click', function(){
            $('.modal').modal('close');
        })
    },
    addToCartHtml(order,theme,index,license){
        let price, html = '';
        if(license === 'Single'){
            price = theme.single_sale_price ? theme.single_sale_price : theme.single_price;
        } else {
            price = theme.multi_sale_price ? theme.multi_sale_price : theme.multi_price;
        }
        if(index === 0){
            $(`.shopping-cart-modal`).find('.inner-container').empty();
            html += `
                        <div class="row col m12">
                            <div class="col m4" style="white-space:nowrap;font-size:1.5em">
                                Total:
                                <span id="total-cart-modal">
                                    ${order.total}
                                </span>
                            </div>
                            <div class="col m8">
                                <a class="btn waves-effect waves-light" style="float:right" href="/checkout">Check Out</a>
                            </div>
                        </div>
                        <div class="cart-items" style="border-top: 1px solid rgba(255,255,255,0.5);padding-top: 5px;">
                    `
        }
        html += `
                    <div class="cart-item row" data-theme="${theme.id}" id="cart-item-${index}">
                        <div class="col m12">
                            <div class="title">
                                <h4 style="margin:0px">
                                    <a href="/themes/${encodeURI(theme.url.toLowerCase())}">${theme.title.charAt(0).toUpperCase()}${theme.title.slice(1)}</a>
                                </h4>
                            </div>
                        </div>
                        <div class="col m6">
                            <div class="img">
                                <a class="cart-modal-image" href="/themes/${encodeURI(theme.url.toLowerCase())}"><img src="${theme.photos[0].photo.url}" alt="${theme.title} Picture"></a>
                            </div>
                        </div>
                        <div class="col m6" style="text-align:right">
                            <div class="remove">
                                <i class="fa fa-times remove-cart-item" id="remove-${index}" index="${index}" style="color:red;font-size:1.5em;margin-top:-25px;cursor:pointer"></i>
                            </div>
                            <div class="license">
                                License:
                                    ${license}
                            </div>
                            <div class="price">
                                ${price}
                            </div>
                        </div>
                    </div>
                    ${index === 0 ? '</div>' : ''}
                `
            return html;
    },
    addToCart(){
        $('#add-to-cart').on('click', function(){
            let theme, license, modal;
            if(location.href.split('/').length > 4 && location.href.split('/')[3] === 'themes'){
                theme = $(`#license-select`).data('theme');
                license = $(`#license-select`).val();
            } else {
                license = $(`#modal-license-select`).val();
                theme = $(this).parents('#modal-purchase').data('theme');
                modal = true;
            }
            let cart = localStorage.getItem('_staple_themes_cart');
            let url = cart ? `${location.origin}/orders/${String(cart)}` : `${location.origin}/orders/`;
            let type = cart ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                data:{theme:theme, license: license, update_type: 1},
                type: type,
                success: (data) => {
                    if($('.cart-number').length){
                        $('.cart-number').text(data.order.themes.length);
                    } else {
                        $("#cart").find('a').append(`
                            <div class="cart-number-container">
                                <span class="cart-number">
                                    1
                                </span>
                            </div>
                        `)
                    }
                    $('#total-cart-modal').text(data.order.total);
                    if(!data.update){
                        if(data.index > 0) $('.cart-items').append(themeApp.addToCartHtml(data.order,data.theme,data.index,data.license));
                        else $(`.shopping-cart-modal`).find('.inner-container').append(themeApp.addToCartHtml(data.order,data.theme,data.index,data.license));
                    } else {
                        let price;
                        if(data.license === 'Single'){
                            price = data.theme.single_sale_price ? data.theme.single_sale_price : data.theme.single_price;
                        } else {
                            price = data.theme.multi_sale_price ? data.theme.multi_sale_price : data.theme.multi_price;
                        }
                        $(`#cart-item-${data.index}`).find('.license').text(`License: ${data.license}`)
                        $(`#cart-item-${data.index}`).find('.price').text(price)
                    }
                    $(".remove-cart-item").unbind('click');
                    themeApp.removeItemFromCart();
                    if(modal) $('#modal-purchase.modal').modal('close');
                },
                error: (error)=> {
                    console.log(error);
                    localStorage.removeItem("_staple_themes_cart")
                    if(error.status === 401){
                        Turbolinks.visit(`/users/sign_up/`, { action: "replace" })
                    }
                }
            });
        });
    },
    watchCartModal(){
        $("#cart").on('click', ()=>{
            $(".shopping-cart-modal").addClass("show");
        })
        $(".shopping-cart-close-container").on('click', ()=>{
            $(".shopping-cart-modal").removeClass('show');
        })
    },
    watchRegisterModal(){

    },
    uploadPhoto(){
        $("#upload-theme-input").change(function() {
             if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#upload-theme-image').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    },
    uploadZip(){
        $('#upload-theme-input-zip').fileupload();
        var credential,policy,signature,store_dir,upload_date,upload_time,name,files,sent;
        var self = this;
        $('#upload-theme-input-zip').on('change', ()=>{
            self.files = $('#upload-theme-input-zip')[0].files
            self.name = $('#upload-theme-input-zip')[0].files[0].name
            $('.file-name').text(self.name)
        })

        $('#upload-theme-input-zip').fileupload({
            url: 'https://staplethemes.s3.amazonaws.com',
            dataType: 'multipart/form-data',
            fileInput: $('#upload-theme-input-zip'),
            autoUpload: false,
            replaceFileInput:false,
            add:  (e, data) => { 
                $.ajax({
                    url: location.href + '/upload',
                    data:{'name': self.name},
                    dataType:'json',
                    type: 'POST',
                    success: (amz_data) => {
                        self.credential = amz_data.credential;
                        self.policy = amz_data.policy;
                        self.signature = amz_data.signature;
                        self.store_dir = amz_data.store;
                        self.upload_date, self.upload_time = amz_data.date_stamp;
                        data.submit();
                    },
                    error: (error)=> {
                        console.log(error);
                    }
                });
            },
            submit: (e, data)=> {
                data.formData = {key:self.store_dir, "Policy":self.policy,"X-Amz-Signature":self.signature,"X-Amz-Credential":self.credential,"X-Amz-Algorithm":"AWS4-HMAC-SHA256", "X-Amz-Date":self.upload_time};
                $(".progress-container").css({'display':'initial'})
            },
            progress: (e, data)=> {
                var progress = `${Math.floor(((parseInt(data.loaded)*0.9)  / (parseInt(data.total))) * 100)}%`;
                $('.inner-progress-bar').css({'transform':`translateX(${progress}%)`});
                $('.progress-text-container').text(progress);
            },
            done: (e, data)=> {
                $('.progress-text-container').text('100%');
                if(e) console.log(e);
            }
        });
    },
    watchCarousel(){
        if($(".carousel").length){
            if($(".carousel").hasClass("initialized")) $(".carousel").carousel('destroy');
            $(".carousel").carousel();
        }
    },
    watchSignInButtons(){
        $("#sign-in-button, #sign-up-button, #update-registration-button").on("click", function(e){
            if(event.target.nodeName === 'INPUT') e.preventDefault();
            $(this).parents('.input-field').find('#submit-input-hidden').trigger('click');
        })
    },
    watchFormButtons(){
        $("#upload-theme-button").on("click",(e)=>{
            e.preventDefault();
            $('#upload-theme-input').trigger('click');
        })
        $("#upload-theme-button-zip").on("click", (e)=>{
            e.preventDefault();
            $("#upload-theme-input-zip").trigger('click');
        })
    },
    watchScrollTo(){
        $('a[href*="#"]')
            // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .click(function(event) {
                // On-page links
                if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
                && 
                location.hostname == this.hostname
                ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                    scrollTop: target.offset().top
                    }, 700, 'easeInQuad', function() {
                    // Callback after animation
                    // Must change focus!
                    var $target = $(target);
                    $target.focus();
                    if ($target.is(":focus")) { // Checking if the target was focused
                        return false;
                    } else {
                        $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                        $target.focus(); // Set focus again
                    };
                    });
                }
                }
            });
        $('a[href="#"]').click(function(e){e.preventDefault()});
    },
    watchNewComments(){
        if($('#new-comment-stars').has('img').length) $('#new-comments-star').empty(); 
         $('#new-comment-stars').raty({
            score: 0,
            path: '/assets',
            scoreName: 'rating'
        });
        $("#comment-submit").on('click', (e)=>{
            e.preventDefault();
            let rating = $('#new-comment-stars').find('input').val()
            let content = $('#comment_content_Dentist').val();

            if(rating && content){
                $.ajax({
                    url: window.location.pathname + '/comments' ,
                    type: 'POST',
                    data: { rating: rating, content:content }
                }).fail((e)=>{
                    console.log(e);
                })
            } else if(content) {
                 Materialize.toast('Rating Is Required', 3000, 'failure-rounded')
            } else if(rating){
                Materialize.toast('Comment Body Is Required', 3000, 'failure-rounded')
            } else {
                Materialize.toast('Both Rating and Comment Body Are Required', 4000, 'failure-rounded')
            }
        })
    },
    removeItemFromCart(){
        $(".remove-cart-item").on('click', function(){
            let cart = localStorage.getItem('_staple_themes_cart');
            let container = $(this).parents('.cart-item');
            let theme = container.data("theme");
            let index = $(this).data('index');
            $.ajax({
                url: `${location.origin}/orders/${String(cart)}`,
                data:{theme:theme, update_type:2},
                type: 'PUT',
                success: (data) => {
                    $('.cart-number').text(data.order.themes.length);
                    $(container).remove();
                    $('#total-cart-modal').text(data.order.total);
                    if($('#total-checkout').length) $('#total-checkout').text(data.order.total);
                    console.log(`index: ${index}`);
                    if($(`#cart-item-${index}`).length) $(`#cart-item-${index}`).remove();
                },
                error: (error)=> {
                    console.log(error);
                }
            });
        })
    },
    backToTop(){
        var showing = false;
		$(window).scroll(()=>{
			if ($(window).scrollTop() > 100 && !showing) {
                showing = true;
				$('#back-to-top').fadeIn();
			} else if($(window).scrollTop() <= 100 && showing) {
                showing = false;
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').on('click', (e)=>{
			$(window).bind("mousewheel", ()=> {
          		$("html, body").stop();
     		});
			e.preventDefault();
			$('html, body').animate({scrollTop : 0},1000);
			return false;
		});
	},
    watchAlert(){
            if($(".alert-container").length){
                setTimeout(()=>{
                    $(".alert-container").addClass('fadeout')
                    setTimeout(()=>{
                        $(".alert-container").remove();
                    },400);
                },4000)
            }
    },
    unbind(){
        $('#back-to-top').unbind('click');
        $(window).unbind('scroll');
    },
    init(){
        // idk why this needs a set timeout, maybe for elements to load?
        setTimeout(()=>{
            themeApp.unbind();
            themeApp.checkCart();
            themeApp.watchAlert();
            themeApp.watchThemeModal();
            themeApp.watchCartModal();
            themeApp.backToTop();
            themeApp.uploadPhoto();
            themeApp.userProfileHover();
            themeApp.watchCarousel();
            themeApp.watchSignInButtons();
            themeApp.watchFormButtons();
            themeApp.uploadZip();
            themeApp.watchScrollTo();
            themeApp.watchNewComments();
            themeApp.removeItemFromCart();
            $('.modal').modal();
            $(".button-collapse").sideNav();
            Waves.displayEffect();
            if(location.href.split('/').length === 5 && location.href.split('/')[3] === 'themes') themeApp.addToCart();
        },1)
    }
}
$(document).on('turbolinks:load', ()=>{themeApp.init()});
