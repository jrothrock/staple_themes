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
    watchCartModal(){
        $("#cart").on('click', ()=>{
            $(".shopping-cart-modal").addClass("show");
        })
        $(".shopping-cart-close-container").on('click', ()=>{
            $(".shopping-cart-modal").removeClass('show');
        })
    },
    uploadPhoto(){
        $("#upload-theme-input").change(function() {
            console.log('change')
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
                console.log(data.formData)
                $(".progress-container").css({'display':'initial'})
            },
            progress: (e, data)=> {
                var progress = Math.floor(((parseInt(data.loaded)*0.9)  / (parseInt(data.total))) * 100);
                $('.inner-progress-bar').css({'transform':`translateX(${progress}%)`});
                $('.progress-text-container').text(progress);
            },
            done: (e, data)=> {
                $('.progress-text-container').text('100');
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
            themeApp.watchAlert();
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
            $(".button-collapse").sideNav();
            Waves.displayEffect();
        },1)
    }
}
$(document).on('turbolinks:load', ()=>{themeApp.init()});
