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
    $(".select2-placeholder-multiple").select2({
        placeholder: "Select State",
    });

    // Teatarea Maxlength
    $('.textarea-maxlength').maxlength({
        alwaysShow: true,
        warningClass: "badge badge-success",
        limitReachedClass: "badge badge-danger",
    });

});