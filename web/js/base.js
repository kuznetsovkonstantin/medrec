$(document).ready(function(){
    $('#btnMenu').on('click',function(){

        $(this).blur();

        if($(this).attr('active') == '0') {
            $(this).attr('active','1').addClass('active');
            $('#verticalMenu').removeClass('hide');
        } else {
            $(this).attr('active','0').removeClass('active');
            $('#verticalMenu').addClass('hide');

        }


    });

    $('.phoneNumber').inputmask('+7 (999) 999-99-99',{ "clearIncomplete": true });


});