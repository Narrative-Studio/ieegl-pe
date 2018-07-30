// Money Mask
var mask_obj = {
    radixPoint: ".",
    groupSeparator: ",",
    digits: 2,
    autoGroup: true,
    //prefix: '$', //No Space, this will truncate the first character
    rightAlign: false,
    oncleared: function () { self.Value(''); }
};

$(document).ready(function() {

    // Basic Select2 select
    $(".select2").select2();

    // Single Select Placeholder
    $(".select2-placeholder").select2({
        placeholder: "Select a state",
        allowClear: true
    });

    // Select With Icon
    $(".select2-icons").select2({
        minimumResultsForSearch: Infinity,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    // Format icon
    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) { return icon.text; }
        var $icon = "<i class='fa fa-" + $(icon.element).data('icon') + "'></i>" + icon.text;

        return $icon;
    }

    // Multiple Select Placeholder
    $(".select2-placeholder-multiple-socios").select2({
        placeholder: "Selecciona los socios",
        minimumInputLength: 4,
        language: "es",
        ajax: {
            url: '/panel/emprendimientos/search-socios',
            dataType: 'json',
            //delay: 250,
            /*data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },*/
            cache: true,
        },
    });

    // Teatarea Maxlength
    $('.textarea-maxlength').maxlength({
        alwaysShow: true,
        warningClass: "badge badge-success",
        limitReachedClass: "badge badge-danger",
    });

    // Money Mask
    $('.money').inputmask("numeric", mask_obj);
    $('.money2').inputmask("numeric", mask_obj);
    $('.integer').inputmask("numeric");

    // Ejecutando Modales
    $('.btn-modal').on('click', function(){
        $('#'+$(this).attr('data-target')).modal('show');
    });
});