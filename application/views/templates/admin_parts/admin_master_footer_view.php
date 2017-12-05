<script type="text/javascript">
    
    $("document").ready(function () {
        var pathname = window.location.pathname;

        if (pathname.indexOf("groups") >= 0) {
            GROUPS.initial();
        } else if (pathname.indexOf("users") >= 0) {
            USERS.initial();
        } else if (pathname.indexOf("languages") >= 0) {
            LANGUAGES.initial();
        } else if (pathname.indexOf("dashboard") >= 0) {
            DASHBOARD.initial();
        }

        $('#check-all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            if($(this).is(':checked')) {
                checkboxes.prop('checked', true);
            } else {
                checkboxes.prop('checked', false);
            }
        });
        $('.checkbox').change(function() {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#check-all').prop('checked', true);
            }else{
                $('#check-all').prop('checked', false);
            }
        });


    });
</script>

</body>
</html>

