(function() {

    $(function() {

        $('#flash-overlay-modal').modal();

        $('.comments_create-form').on('keydown', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).submit();
            }
        });


    });

})();