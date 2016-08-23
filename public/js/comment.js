$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, settings) {
            if (settings.type == 'POST' || settings.type == 'PUT' || settings.type == 'DELETE') {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('[name="csrf_token"]').attr('content'));
            }
        }
    });

    $('.btn-edit').on('click', function(e) {
        e.preventDefault();
        var element = $(this);
        var parent = element.parents('.comment-content').addClass('hidden');
        parent.prev().removeClass('hidden');
    });

    $('.btn-cancel').on('click', function(e) {
        e.preventDefault();
        var element = $(this);
        var edit = element.parents('.comment-edit').addClass('hidden');
        edit.next().removeClass('hidden');
    });

    $('#btn-comment').on('click', function(e) {
        e.preventDefault();
        var content = $('#content').val();
        var postId = $('#post-id').val();

        $.ajax({
            type: 'POST',
            url: $('#btn-comment').data('url'),
            data: {
                content: content,
                postId: postId,
            },
            success: function(data, status) {
                location.reload(true);
            },
        });
    });

    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var element = $(this)
        var id = element.data('id');
        var url = element.data('url');

        $.ajax({
            type: 'DELETE',
            url: url,
            success: function (data, status) {
                element.parents('.box-single-comment').remove();
            },
        });
    });

    $('.btn-update').on('click', function(e) {
        e.preventDefault();
        var element = $(this);
        var id = element.data('id');
        var content = element.parents().find('.content-edit').val();
        var url = element.data('url');

        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                id: id,
                content: content,
            },
            success: function(data, status) {
                var dataComment = data.dataComment;
                var edit = element.parents('.comment-edit').next();
                edit.prev().addClass('hidden');
                edit.children('p').html(dataComment['content']);
                edit.removeClass('hidden');
            },
        });
    });
});
