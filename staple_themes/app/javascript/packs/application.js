/* eslint no-console:0 */
// This file is automatically compiled by Webpack, along with any other files
// present in this directory. You're encouraged to place your actual application logic in
// a relevant structure within app/javascript and only use these pack files to reference
// that code so it'll be compiled.
//
// To reference this file, add <%= javascript_pack_tag 'application' %> to the appropriate
// layout file, like app/views/layouts/application.html.erb
var themeApp = {
    userProfileHover:()=>{
        $("#profile-hover").dropdown({ hover: true, inDuration: 300, outDuration: 225, alignment: 'left', constrain_width: false, belowOrigin: true });
        $("#profile-hover").on('click', (e)=>{
            e.preventDefault();
            $("#profile-hover").trigger('hover');
        })
    },
    uploadZip:()=>{
        var credential,policy,signature,store_dir,upload_date,upload_time,name,files,sent;
        var self = this;
        $('#upload-theme-input-zip').on('change', ()=>{
            self.files = $('#upload-theme-input-zip')[0].files
            self.name = $('#upload-theme-input-zip')[0].files[0].name
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
            },
            progress: (e, data)=> {
            var progress = Math.floor(((parseInt(data.loaded)*0.9)  / (parseInt(data.total))) * 100);
            console.log(progress);
            },
            done: (e, data)=> {
                console.log('great success 100%!');
                if(e) console.log(e);
            }
        });
    },
    watchFormButtons:()=>{
        $("#upload-theme-button").on("click",(e)=>{
            e.preventDefault();
            $('#upload-theme-input').trigger('click');
        })
        $("#upload-theme-button-zip").on("click", (e)=>{
            e.preventDefault();
            $("#upload-theme-input-zip").trigger('click');
        })
    },
    backToTop: ()=> {
		$(window).scroll(()=>{
			if ($(this).scrollTop() > 1) {
				$('#back-to-top').fadeIn();
			} else {
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
    watchAlert: ()=>{
            if($(".alert-container").length){
                console.log('has container')
                setTimeout(()=>{
                    $(".alert-container").addClass('fadeout')
                    setTimeout(()=>{
                        $(".alert-container").remove();
                    },400);
                },4000)
            }
    },
    init: ()=>{
        // idk why this needs a set timeout, maybe for elements to load?
        setTimeout(()=>{
            themeApp.watchAlert();
            themeApp.backToTop();
            themeApp.userProfileHover();
            $(".button-collapse").sideNav();
            themeApp.watchFormButtons();
        },1)
    }
}
$(document).on('turbolinks:load', themeApp.init());