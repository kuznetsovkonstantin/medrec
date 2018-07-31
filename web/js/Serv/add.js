var $collectionHolder;
var $addTagLink = $('#addNewTag');
$collectionHolder = $('#tagsTbl');

function delTag() {
    $('.delTag').on('click',function() {
        $(this).parent().parent().remove();

        if($('.tagEl').length == 0)
            $('#tagsTbl').append('<tr class="noneTags"><td colspan="3">Теги не добавлены</td></tr>');

    });
}

$(document).ready(function(){

    $('#delImg').popover();
    $('.addBlockBut,.delTag,#delServAtten').tooltip();
    //$('#modalDel').modal();

    $collectionHolder = $('#tagsTbl');

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('#addBlockBut').on('click', function(e) {

        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);
        $collectionHolder.append('<tr class="tagEl"><td>'+$collectionHolder.data('index')+'</td><td class="addValI" ind="'+$collectionHolder.data('index')+'">'+newForm+'</td><td><span title="удалить тег" class="delTag glyphicon glyphicon-trash"></span></td></tr>');

        var addVlTr = $('.addValI[ind="'+$collectionHolder.data('index')+'"]');

        addVlTr.find('label').remove();
        addVlTr.find('input').addClass('form-control');

        $('.noneTags').remove();

        $('.delTag').off('click');
        delTag();
    });

    delTag();

    $('#delImg').on('click',function() {
        $('#imgFormView').addClass('hidden');
        $('#imgFormWidget').removeClass('hidden').find('input').first().prop('required',true);
    });
});