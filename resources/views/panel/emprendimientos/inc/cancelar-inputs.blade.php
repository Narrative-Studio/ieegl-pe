<script type="text/javascript">
    $(document).ready(function () {
        $('input, select, textarea').attr('disabled','disabled');
        $('input[type="file"]').css('display','none');
        $('input[type="radio"]:checked').css('display','none');
        $('.form-body .btn').css('display','none');
    })
</script>