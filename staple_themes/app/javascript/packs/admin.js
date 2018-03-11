var themeAppAdmin = {
    adminHover(){
        $("#admin-hover, #admin-create-hover").dropdown({ hover: true, inDuration: 300, outDuration: 225, alignment: 'left', constrain_width: false, belowOrigin: true });
        $("#admin-hover, #admin-create-hover").on('click', (e)=>{
            e.preventDefault();
            $("#admin-hover").trigger('hover');
        })
    },
    watchDiscountSubmit(){
        $(`#submit-discount-button`).on('click', function(e){
            e.preventDefault();
            $(this).addClass('disabled');
            $('#submit-discount-hidden').trigger('click');
        })
    },
    init(){
        themeAppAdmin.adminHover();
        themeAppAdmin.watchDiscountSubmit();
    }
}
$(document).on('turbolinks:load', ()=>{themeAppAdmin.init()});