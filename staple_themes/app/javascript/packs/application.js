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
    watchDownload(){
        $('.download-btn').on('click', function(){
            if(!/Mobile|webOS|Mobi/.test(navigator.userAgent)){
                let theme = $(this).data('theme');
                $.ajax({
                    url: `${location.origin}/themes/${theme}/download`,
                    type: 'GET',
                    success: (data) => {
                        let tag = document.createElement('a');
                        tag.setAttribute('href', data.url);
                        tag.setAttribute('target', "_blank");
                        tag.setAttribute('download', data.name);
                        tag.click();
                    },
                    error: (error)=> {
                        console.log(error);
                    }
                });
            } else {
                Materialize.toast('Downloads Disabled For Mobile Devices', 4000, 'failure-rounded')
            }
        });
    },
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
            $('#modal-purchase').modal('open');
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
            $('#modal-purchase').modal('close');
        })
    },
    addToCartHtml(order,theme,index,license){
        let price, html = '';
        if(license === "Single"){
            license = "Single";
            price = theme.single_sale_price ? theme.single_sale_price : theme.single_price;
        } else {
            license = "Multi"
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
    watchLogOut(){
        $(`#logout-button`).on('click', function(){
            localStorage.clear();
        })
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
                        let cart_id = window.innerWidth > 500 ? "#cart" : "#cart-mobile"
                        $(cart_id).find('a').append(`
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
                    localStorage.removeItem("_staple_themes_cart")
                    $('#modal-purchase.modal').modal('open');
                    if(error.status === 401){
                        themeApp.watchLoginModal($(this));
                        $(`#modal-sign-in`).modal('open')
                        $('#modal-sign-in-tabs').find('.indicator').css({'right':`${$('#modal-sign-in-tabs').width() / 2}px`,'left':'0px' })
                    } else if(error.status === 404) {
                        $(this).trigger('click');
                    } else {
                        Materialize.toast('Failed To Add To Cart. Please Try Again', 3000, 'failure-rounded')
                    }
                }
            });
        });
    },
    watchCartModal(){
        $("#cart, #cart-mobile").on('click', ()=>{
            $(".shopping-cart-modal").addClass("show");
        })
        $(".shopping-cart-close-container").on('click', ()=>{
            $(".shopping-cart-modal").removeClass('show');
        })
    },
    loginHTML(user,admin){
        let html = '';
        if(admin){
            html+= `<li>
                        <a href="/themes/new">Create Theme</a>
                    </li>`
        }
        html += `
        <li class="dropdown-button" data-activates="dropdown1" id="profile-hover">
            <a class="profile-dropdown" href="" style="border-left: 1px solid rgba(255,255,255,0.5)">
                <i class="fa fa-user-circle"></i>
                <i class="fa fa-angle-down" style="margin-left:2px"></i>
                    ${user}
            </a>
        </li>
        <ul class="dropdown-content" id="dropdown1">
            <li>
                <a href="/users/${user}">Profile</a>
            </li>
            <li>
                <a href="/users/edit">Settings</a>
            </li>
            <li>
                <a href="/users/${user}/purchases">Purchases</a>
            </li>
            <li class="divider"></li>
            <li>
                <a rel="nofollow" data-method="delete" href="/users/sign_out">Logout</a>
            </li>
        </ul>
        `;
        return html;
    },
    watchLoginModal(button){
        $(`#log-in-button-modal, #sign-up-button-modal`).unbind('click');

        //watch login
        $(`#log-in-button-modal`).on('click', (e)=>{
            $(`#log-in-button-modal`).addClass('disabled');
            let username = $(`#username_log_in`).val();
            let password = $(`#password_log_in`).val();
            $.ajax({
                url: window.location.origin + '/users/sign_in.json',
                type: 'POST',
                data: { user:{login: username, password:password, remember_me:0 }},
                success: (data, status, xhr) => {
                    $("meta[name='csrf-token']").attr("content", xhr.getResponseHeader('X-CSRF-TOKEN'))
                    $(`.right.hide-on-med-and-down`).empty();
                    $(`.right.hide-on-med-and-down`).html(themeApp.loginHTML(data.username, data.admin))
                    $(`#modal-sign-in`).modal('close');
                    themeApp.userProfileHover();
                    $('#modal-purchase.modal').modal('close');
                    button.click();
                },
                error: (error, status, xhr)=> {
                    console.log(status);
                    console.log(error);
                    $(`#log-in-button-modal`).removeClass('disabled');
                    if(error.status === 401){
                        if(!$(`#modal-login-error-text`).length) $(`#username_log_in`).parent().parent().prepend(`<span style='text-transform:capitalize;text-align:center;display:block;color:red;position:relative;top:-10px' id='modal-login-error-text'>${error.responseJSON.error}</span>`)
                        $(`#username_log_in`).parent().addClass("error");
                        $(`#password_log_in`).parent().addClass("error");
                    } else if(error.status === 500){
                        Materialize.toast('Internal Server Error Please Try Again', 3000, 'failure-rounded');
                    }
                }
            })
        })

        //watch signup
        $(`#sign-up-button-modal`).on('click', (e)=>{
            $(`#sign-up-button-modal`).addClass('disabled');
            let username = $(`#username_sign_up`).val();
            let email = $(`#email_sign_up`).val();
            let password = $(`#password_sign_up`).val();
            let password_confirmation = $(`#password_confirmation_sign_up`).val();
            $.ajax({
                url: window.location.origin + '/users.json',
                type: 'POST',
                data: { user:{username: username, email:email, password:password,password_confirmation:password_confirmation }},
                success: (data, status, xhr) => {
                    $("meta[name='csrf-token']").attr("content", xhr.getResponseHeader('X-CSRF-TOKEN'))
                    $(`.right.hide-on-med-and-down`).empty();
                    $(`.right.hide-on-med-and-down`).html(themeApp.loginHTML(data.username, data.admin))
                    $(`#modal-sign-in`).modal('close');
                    themeApp.userProfileHover();
                    $('#modal-purchase.modal').modal('close');
                    button.click();
                },
                error: (error)=> {
                    $(`#sign-up-button-modal`).removeClass('disabled')
                    console.log(error);
                    if(error.responseJSON.errors.email){
                        $('#email_sign_up').parent().addClass('error');
                        $("#email_sign_up").parent().append(`<span style='text-transform:capitalize;color:red;position:relative;top:-10px'>Email ${error.responseJSON.errors.email[0]}</span>`);
                    }
                    if(error.responseJSON.errors.username){
                        $('#username_sign_up').parent().addClass('error');
                        $("#username_sign_up").parent().append(`<span style='text-transform:capitalize;color:red;position:relative;top:-10px'>Username ${error.responseJSON.errors.username[0]}</span>`);
                    }
                    if(error.responseJSON.errors.password){
                        $('#password_sign_up').parent().addClass('error');
                        $('#password_confirmation_sign_up').parent().addClass('error');
                        if(error.responseJSON.errors.password[0] === 'is too short (minimum is 6 characters)'){
                            $("#password_sign_up").parent().append(`<span style='text-transform:capitalize;color:red;position:relative;top:-10px'>Password ${error.responseJSON.errors.password[0]}</span>`);
                        } 
                    }
                }
            })
        })
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
            $(this).addClass('disabled');
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
        if($('#new-comment-stars').has('img').length) $('#new-comment-stars').empty(); 
         $('#new-comment-stars').raty({
            score: 0,
            path: 'https://cdn.staplethemes.com/images',
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
    watchResetForm(){
        $(`#reset-password-button-modal`).on('click', function(){
            $(this).addClass('disabled');
            let login = $(`#username_reset`).val()
            if(!login){
                $(`#username_reset`).parent().addClass('error');
                return;
            }
             $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: { login:login },
                    success: (data) => {
                        Turbolinks.visit(`/`, { action: "replace" })
                    },
                    error:(data) =>{
                        $(this).removeClass('disabled')
                        Materialize.toast('User Not Found', 4000, 'failure-rounded')
                        $(`#username_reset`).val('').blur()
                    }
                })
        });
    },
    watchResetConfirmationForm(){
        $(`#reset-password-confirm-button-modal`).on('click', function(){
            $(this).addClass('disabled');
            let password = $(`#password_reset`).val()
            let confirm_password = $(`#password_confirmation_reset`).val();
            let user_uuid = $(`#user_uuid`).val()
            if(!password){
                $(`#password_reset`).parent().addClass('error');
                return;
            }
            if(!confirm_password){
                $(`#password_confirmation_reset`).parent().addClass('error');
                return;
            }
            if(password != confirm_password){
                $(`#password_reset`).parent().addClass('error');
                $(`#password_confirmation_reset`).parent().addClass('error');
                Materialize.toast('Passwords Must Match', 4000, 'failure-rounded')
                return;
            }
             $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: { password:password,user_uuid:user_uuid },
                    success: (data) => {
                        Turbolinks.visit(`/`, { action: "replace" })
                    },
                    error:(data) =>{
                        $(this).removeClass('disabled')
                        Materialize.toast('User Not Found', 4000, 'failure-rounded')
                        $(`#username_reset`).val('').blur()
                    }
                })
        });
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
    watchContact(){
        $('#submit-contact-form').on('click', (e)=>{
            $('#submit-contact-form').addClass('disabled');
            let name = $('#contact-form-name').val();
            let email = $('#contact-form-email').val()
            let type = $('#contact-form-type').val()
            let body = $('#contact-form-body').val()
            if(!name){
                $('#contact-form-name').addClass('invalid');
            }
            if(!email){
                $('#contact-form-email').addClass('invalid');
            }
            if(!type){
                $('#contact-form-type').addClass('invalid');
            }
            if(!body){
                $('#contact-form-body').addClass('invalid');
            }
            if(!name || !email || !type || !body) return;
            $.ajax({
                url: `${location.origin}/contact`,
                data:{name:name, email:email, type:type,body:body},
                type: 'POST',
                success: (data) => {
                    Materialize.toast('Contact Successfully Sent', 3500, 'success-rounded')
                    $('#contact-form-name,#contact-form-email,#contact-form-body').val("").blur();
                    $('#contact-form-type').val('General').blur();
                    $('#submit-contact-form').removeClass('disabled');
                },
                error: (error)=> {
                    $('#submit-contact-form').removeClass('disabled')
                    Materialize.toast('Contact Failed To Send. Please Try Again', 3000, 'failure-rounded')
                }
            });
        })
    },
    checkContactType(){
        if(window.location.pathname === '/contact'){
            let string = decodeURIComponent(window.location.search);
            if(string){
                string = string.slice(1)
                let type = string.split('=')[1].split(' ');
                for(let i = 0; i < type.length; i++){
                    type[i] = `${type[i].charAt(0).toUpperCase()}${type[i].slice(1)}`
                }
                type = type.join(' ');
                $('#contact-form-type').val(type);
            }
        }
    },
    unbind(){
        $('#back-to-top').unbind('click');
        $(window).unbind('scroll');
    },
    init(){
        // idk why this needs a set timeout, maybe for elements to load?
        setTimeout(()=>{
            themeApp.watchLogOut();
            themeApp.unbind();
            themeApp.checkCart();
            themeApp.watchAlert();
            themeApp.watchThemeModal();
            themeApp.watchCartModal();
            themeApp.backToTop();
            themeApp.userProfileHover();
            themeApp.watchCarousel();
            themeApp.watchDownload();
            themeApp.watchSignInButtons();
            themeApp.watchFormButtons();
            themeApp.watchScrollTo();
            themeApp.watchNewComments();
            themeApp.removeItemFromCart();
            themeApp.watchContact();
            themeApp.checkContactType();
            themeApp.watchResetForm();
            themeApp.watchResetConfirmationForm();
            $('.modal').modal();
            $(".button-collapse").sideNav();
            Waves.displayEffect();
            if(location.href.split('/').length === 5 && location.href.split('/')[3] === 'themes') themeApp.addToCart();
        },1)
    }
}
$(document).on('turbolinks:load', ()=>{themeApp.init()});
