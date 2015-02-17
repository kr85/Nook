var statusObject = {
    ajaxSetup: function() {
        "use strict";

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
    },
    deleteStatus: function(thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var answer = confirm('Are you sure?');
            if (answer) {
                var target = $(this).attr('id');
                statusObject.deleteStatusAjax('#' + target);
            }
        });
    },
    deleteStatusAjax: function(target) {
        "use strict";

        var deleteStatus = $(target).attr('action');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: deleteStatus,
            type: 'POST',
            data: { _method: 'DELETE', _token: token },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
};

$(function() {
    statusObject.ajaxSetup();
    statusObject.deleteStatus('.delete-status');
});