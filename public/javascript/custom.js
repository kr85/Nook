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
            dataType: 'json',
            data: ({ _method: 'DELETE', _token: token }),
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    },
    postStatus: function(thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            statusObject.postStatusAjax('#post-status-form');
        });
    },
    postStatusAjax: function(target) {
        "use strict";

        var postStatus = $(target).attr('action');
        var text = $('#post-status-textarea').val();
        var token = $('input[name="_token"]').val();
        var userId = $('input[name="userId"]').val();

        $.ajax({
            url: postStatus,
            type: 'POST',
            dataType: 'json',
            data: ({ userId: userId, body: text, _token: token }),
            success: function(response) {
                if (response.success) {
                    $(target)[0].reset();
                    location.reload();
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    },
    postComment: function(thisIdentity) {
        "use strict";

        $(document).on('keydown', thisIdentity, function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                var formId = $(this).attr('id');
                var array = formId.split('-');
                var statusId = array[0];
                statusObject.postCommentAjax('#' + formId, formId, statusId);
            }
        });
    },
    postCommentAjax: function(target, id, statusId) {
        "use strict";

        var postComment = $(target).attr('action');
        var text = $('#post-comment-textarea-' + id).val();
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: postComment,
            type: 'POST',
            dataType: 'json',
            data: ({ status_id: statusId, body: text, _token: token }),
            success: function(response) {
                if (response.success) {
                    $(target)[0].reset();
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
    statusObject.postStatus('#post-status');
    statusObject.postComment('.comments_create-form');
    $('#flash-overlay-modal').modal();
});