$(document).ready(function(){
    $('#sortable2').sortable({
        axis: 'y',
        handle: '.handle',
        dragClass: "sortable-drag",
        ghostClass: 'ghost-class',
        dataIdAttr: 'id',
        allowDuplicates: false,
        onSort: function (evt) {
            reorder();
        },
    });

    $('#select_categoria').on('change',function(){
        $('#sortable .listados').addClass('hidden');
        $('#sortable #'+$(this).val()).removeClass('hidden');
    });

    //
    $('#sortable input[type="checkbox"]').on('change',function(){
        console.log($(this).val());
        if($(this).is(':checked')){
            if($("#sortable2 #"+$(this).val()).length==0){
                addQuestion($(this).val(),true);
            }
        }else{
            $("#sortable2 #"+$(this).val()).remove();
        }
    });
    $('#guardar_pregunta').on('click',function(){
        addNewQuestion(true);
    });

    // Json
    if(json!='') parsePreguntas();
});
function addTitle(reordenar){
    var item = $('#cloneTitle').clone().removeClass('hidden').removeAttr('id').appendTo( "#sortable2" );
    //window.scrollTo(0,document.body.scrollHeight);
    if(reordenar){reorder()}else{return item};
}
function addQuestion(question, reordenar){
    var item = $('#'+question).clone().appendTo( "#sortable2" );
    $('#sortable2 #'+question+' .hidden').removeClass('hidden');
    $('#sortable2 #'+question+' .custom-checkbox').remove();
    //window.scrollTo(0,document.body.scrollHeight);
    if(reordenar){reorder()}else{return item};
}
function addNewQuestion(reordenar){
    var $new = $('#campo_nuevo').clone().removeAttr('id');
    $new.find("select").each(function(i){
        this.selectedIndex = $('#campo_nuevo').find("select")[i].selectedIndex;
    });
    $('.hidden', $new).removeClass('hidden');
    $('.form-actions', $new).remove();
    $('.uuid', $new).val(uuidv4());
    $( "#sortable2" ).append( $new );
    //window.scrollTo(0,document.body.scrollHeight);
    if(reordenar){reorder()}else{return $new};
    $("#campo_nuevo input[type='text'], #campo_nuevo textarea").val('');
    $('#campo_nuevo select').prop('selectedIndex',0);
}
function deleteItem(item){
    let del = $(item).parents('.item');
    var id = del.prop('id');
    if(id!='') $("#sortable #"+id).find('input[type="checkbox"]').prop('checked', false);
    $(del).remove();
    reorder();
}
function muestra(){
    var order = $('#sortable2').sortable('toArray');
}
function reorder(){
    $('#sortable2 .item').each(function(index) {
        var $this = $(this);
       $("input,select,textarea", $this).each(function(i) {
           var name= 'preguntas['+index+']['+$(this).attr('data-name')+']';
           $(this).attr('name', name);
        });
    });
}
function cambioTipoPregunta(obj){
    var item = $(obj).parents('.item');
    if($(obj).val()=='combo' || $(obj).val()=='multiple'){
        $(item).find('.nueva_respuestas_select').removeClass('hidden');
    }else{
        $(item).find('.nueva_respuestas_select').addClass('hidden');
        $(item).find('.nueva_respuestas_select').find('textarea').val('');
    }
}
function parsePreguntas(){
    $('.cargador_preguntas').removeClass('hidden');
    var preguntas_json = JSON.parse(json);
    for(var i=0;i<Object.keys(preguntas_json).length;i++){
        var pregunta = preguntas_json[i];
        if(preguntas_json[i]!=undefined) {
            switch (preguntas_json[i].tipo) {
                case 'categorias':
                    var item = addTitle(false);
                    $(item).find('.titulos').val(pregunta.nombre);
                    break;
                case 'usuario':
                    var item = addQuestion('usuario_' + pregunta.campo, false);
                    $('#sortable #usuario_' + pregunta.campo).find('input[type="checkbox"]').prop('checked', true);
                    $("input[data-name='nombre']", item).val(pregunta.nombre);
                    $("input[data-name='desc']", item).val(pregunta.desc);
                    break;
                case 'cuenta':
                    var item = addQuestion('cuenta_' + pregunta.campo, false);
                    $('#sortable #cuenta_' + pregunta.campo).find('input[type="checkbox"]').prop('checked', true);
                    $("input[data-name='nombre']", item).val(pregunta.nombre);
                    $("input[data-name='desc']", item).val(pregunta.desc);
                    break;
                case 'emprendimiento':
                    var item = addQuestion('emprendimiento_' + pregunta.campo, false);
                    $('#sortable #emprendimiento_' + pregunta.campo).find('input[type="checkbox"]').prop('checked', true);
                    $("input[data-name='nombre']", item).val(pregunta.nombre);
                    $("input[data-name='desc']", item).val(pregunta.desc);
                    break;
                case 'catalogos':
                    var item = addQuestion('catalogos_' + pregunta.campo, false);
                    $('#sortable #catalogos_' + pregunta.campo).find('input[type="checkbox"]').prop('checked', true);
                    $("input[data-name='nombre']", item).val(pregunta.nombre);
                    $("input[data-name='desc']", item).val(pregunta.desc);
                    break;
                case 'nueva':
                    var item = addNewQuestion(false);
                    $("input[data-name='nombre']", item).val(pregunta.nombre);
                    $("input[data-name='desc']", item).val(pregunta.placeholder);
                    $("select[data-name='tipo_pregunta']", item).val(pregunta.tipo_pregunta);
                    if (pregunta.tipo_pregunta == 'combo' || pregunta.tipo_pregunta == 'multiple') {
                        $(item).find('.nueva_respuestas_select').removeClass('hidden');
                    } else {
                        $(item).find('.nueva_respuestas_select').addClass('hidden');
                        $(item).find('.nueva_respuestas_select').find('textarea').val('');
                    }
                    if (pregunta.respuestas != null) $("textarea[data-name='respuestas']", item).val(pregunta.respuestas.replace(/\|/g, "\n"));
                    break;
            }
        }
    }
    reorder();
    $('.cargador_preguntas').addClass('hidden');
}

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}