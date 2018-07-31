function delTag() {
    $('.delTag').on('click',function() {
        $(this).parent().parent().remove();

        if($('.tagEl').length == 0)
            $('.noneTags').removeClass('hide');

        getServSpec ();

    });
}

function getServSpec () {
    var arrSid = [];
    $.each($('.delTag'),function(ind,vl){
        arrSid.push($(this).attr('sid'));
    });

    $('#specServJSON').val($.toJSON(arrSid));
}

$(document).ready(function() {

    $('#delImg').popover();
    $('.addBlockBut,.delTag,#delServAtten').tooltip();

    delTag();

    $('#addBlockBut').on('click',function(){
        $('.servTr').attr('dis','0').attr('active','0');

        $.each($('.delTag'),function(ind,vl){
            $('.servTr[sid="'+$(this).attr('sid')+'"]').attr('dis','1');
        });
    });

    $('.servTr').on('click',function(){

        if($(this).attr('dis') == '0') {
            if ($(this).attr('active') == '0')
                $(this).attr('active', '1');
            else
                $(this).attr('active', '0');
        }
    });

    $('#setSpecServ').on('click',function() {
        if($('.servTr[active="1"]').length > 0) {

            $('.noneTags').addClass('hide');

            $.each($('.servTr[active="1"]'), function (ind, vl) {
                $('#tagsTbl').append('' +
                    '<tr class="tagEl">' +
                    '<td>' + ($('.tagEl').length + 1) + '</td>' +
                    '<td class="text-left">' + $(this).find('td.servNameTb').text() + '</td>' +
                    '<td><span data-toggle="tooltip" data-placement="left" class="delTag glyphicon glyphicon-trash" sid="' + $(this).attr('sid') + '" data-original-title="удалить услугу"></span></td>' +
                    '</tr>');
            });

            $('.delTag').off('click');
            delTag();

            getServSpec ();
        }

        $('#modalServ').modal('hide');

    });

});