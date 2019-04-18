$(document).ready(function(){
    $('#sortable2').sortable({
        axis: 'y',
        handle: '.handle',
        dragClass: "sortable-drag",
        dataIdAttr: 'id',
        allowDuplicates: false,
        /*onEnd: function (evt) {
            reorder();
        },
        onAdd: function (evt) {
            reorder();
        },
        onUpdate: function (evt) {
            reorder();
        },*/
        onSort: function (evt) {
            reorder();
        },
    });

    //
    $('#sortable input[type="checkbox"]').on('change',function(){
        if($(this).is(':checked')){
            if($("#sortable2 #"+$(this).val()).length==0){
                addQuestion($(this).val());
            }
        }else{
            $("#sortable2 #"+$(this).val()).remove();
        }
    });

    $('#select_categoria').on('change',function(){
        $('#sortable .listados').addClass('hidden');
        $('#sortable #'+$(this).val()).removeClass('hidden');
    });

    $('#guardar_pregunta').on('click',function(){
        addNewQuestion();
    });
});
function addTitle(){
    $('#cloneTitle').clone().removeClass('hidden').removeAttr('id').appendTo( "#sortable2" );
    reorder();
}
function addQuestion(question){
    $('#'+question).clone().appendTo( "#sortable2" );
    $('#sortable2 #'+question+' .hidden').removeClass('hidden');
    $('#sortable2 #'+question+' .custom-checkbox').remove();
    reorder();
}
function addNewQuestion(){
    var $new = $('#campo_nuevo').clone().removeAttr('id');
    $new.find("select").each(function(i){
        this.selectedIndex = $('#campo_nuevo').find("select")[i].selectedIndex;
    });
    $('.hidden', $new).removeClass('hidden');
    $('.form-actions', $new).remove();
    $( "#sortable2" ).append( $new );
    reorder();
    $("#campo_nuevo input, #campo_nuevo textarea").val('');
    $('#campo_nuevo select').prop('selectedIndex',0);
}
function deleteItem(item){
    let del = $(item).parent().parent().parent();
    $(del).remove();
}
function muestra(){
    var order = $('#sortable2').sortable('toArray');
    console.log(order);
}
function reorder(){
    $('#sortable2 .item').each(function(index) {
        var $this = $(this);
       $("input,select,textarea", $this).each(function(i) {
           var name= 'preguntas['+$(this).attr('data-dato')+']['+index+']['+$(this).attr('data-name')+']';
           $(this).attr('name', name);
        });
    });
}