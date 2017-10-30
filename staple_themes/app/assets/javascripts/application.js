// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or any plugin's vendor/assets/javascripts directory can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// compiled file. JavaScript code in this file should be added after the last require_* statement.
//
// Read Sprockets README (https://github.com/rails/sprockets#sprockets-directives) for details
// about supported directives.
//
//= require jquery
//= require jquery.turbolinks
//= require jquery_ujs
//= require turbolinks
//= require materialize-sprockets
//= require_tree .
var themeApp = {
    userProfileHover:function(){
        $("#profile-hover").on('hover,click', function(e){
            // $("#profile-hover").dropdown();
            e.preventDefault();
        })
    },
    uploadZip:function(){
        let credential,policy,signature,store_dir,upload_date,upload_time,name,files,sent;
        let self = this;
        $(`#upload-theme-input-zip`).on('change', function(){
            self.files = $(`#upload-theme-input-zip`)[0].files
            self.name = $(`#upload-theme-input-zip`)[0].files[0].name
            console.log(self.name)
        })


        $(`#upload-theme-input-zip`).fileupload({
            url: `https://staplethemes.s3.amazonaws.com`,
            dataType: 'multipart/form-data',
            fileInput: $(`#upload-theme-input-zip`),
            autoUpload: false,
            replaceFileInput:false,
            add: function (e, data) { 
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
                    error: (error) => {
                        console.log(error);
                    }
                });
            },
            submit: (e, data) => {
                data.formData = {key:`${self.store_dir}`, "Policy":self.policy,"X-Amz-Signature":self.signature,"X-Amz-Credential":self.credential,"X-Amz-Algorithm":"AWS4-HMAC-SHA256", "X-Amz-Date":self.upload_time};
                console.log(data.formData)
            },
            progress: (e, data) => {
            let progress = Math.floor(((parseInt(data.loaded)*0.9)  / (parseInt(data.total))) * 100);
            console.log(progress);
            },
            done: (e, data) => {
                console.log('great success 100%!');
                if(e) console.log(e);
            }
        });
    },
    watchFormButtons:function(){
        $("#upload-theme-button").on("click",function(e){
            e.preventDefault();
            $('#upload-theme-input').trigger('click');
        })
        $("#upload-theme-button-zip").on("click", function(e){
            e.preventDefault();
            $("#upload-theme-input-zip").trigger('click');
        })
    },
    backToTop: function() {
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').on('click', function(e){
			$(window).bind("mousewheel", function() {
          		$("html, body").stop();
     		});
			e.preventDefault();
			$('html, body').animate({scrollTop : 0},1000);
			return false;
		});
	},
    watchAlert: function(){
            if($(".alert-container").length){
                console.log('has container')
                setTimeout(function(){
                    $(".alert-container").addClass('fadeout')
                    setTimeout(function(){
                        $(".alert-container").remove();
                    },400);
                },4000)
            }
    },
    init: function(){
        // idk why this needs a set timeout
        setTimeout(()=>{
            themeApp.watchAlert();
            themeApp.backToTop();
            // themeApp.watchFormButton();
        },1)
    }
}
$(document).on('turbolinks:render', themeApp.init());