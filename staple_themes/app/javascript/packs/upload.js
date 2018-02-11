import 'simplemde/dist/simplemde.min.css';
import * as SimpleMDE from 'simplemde/dist/simplemde.min.js';
var themeAppUpload = {
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
            $('#theme_download_name').val(self.name)
        })

        $('#upload-theme-input-zip').fileupload({
            url: 'https://staplethemes.s3.amazonaws.com',
            dataType: 'multipart/form-data',
            fileInput: $('#upload-theme-input-zip'),
            autoUpload: false,
            replaceFileInput:false,
            add:  (e, data) => { 
                $(`#submit-theme-button`).addClass('disabled');
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
                $(`#submit-theme-button`).removeClass('disabled');
                if(e) console.log(e);
            }
        });
    },
    simplemde(){
        var simplemde = new SimpleMDE({ element: jQuery("#markdown-editor")[0]});
    },
    watchSubmit(){
        $(`#submit-theme-button`).on('click', function(e){
            e.preventDefault();
            $(this).addClass('disabled');
            $('#submit-theme-hidden').trigger('click');
        })
    },
    init(){
        themeAppUpload.simplemde();
        themeAppUpload.uploadZip();
        themeAppUpload.uploadPhoto();
        themeAppUpload.watchSubmit();
    }
}
$(document).on('turbolinks:load', ()=>{themeAppUpload.init()});