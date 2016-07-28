$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, settings) {
            if (settings.type == 'POST' || settings.type == 'PUT' || settings.type == 'DELETE') {
                xhr.setRequestHeader("X-CSRF-TOKEN", $('[name="csrf_token"]').attr('content'));
            }
        }
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_url').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function () {
        $('#image_hidden').val('');
        readURL(this);
    });
    $("#btn-back").click(function () {
        window.history.back();
    });
    $('section').on('click', '#btn-delete', function (event) {
        var response = confirm($(this).data('alert'));
        if (response) {
            var arr = [];
            $("input[type='checkbox']:checked").each(function () {
                arr.push($(this).val())
            });

            if (arr.length == 0) {
                alert($(this).data('check'));
                return false;
            }
            $.ajax({
                type: 'DELETE',
                url: $(this).data('url'),
                dataType: 'json',
                data: {
                    ids: arr
                },
                success: function (data, status) {
                    window.location.replace($('#btn-delete').data('manage'));
                }
            });
        }
    });
    $('section').on('click', '#btn-create', function (event) {
        window.location.replace($(this).data('url'));
    });
    $('section').on('click', '#btn-export', function (event) {
        window.location.href = $(this).data('url');
    });
    $('section').on('click', '.select-all', function (event) {
        $("input[type='checkbox']").prop('checked', !$("input[type='checkbox']").prop('checked'));
    });
    $('section').on('click', '#btn-destroy', function (event) {
        $.ajax({
            type: 'DELETE',
            url: $(this).data('url'),
            success: function (data, status) {
                window.location.replace($('#btn-destroy').data('redirect'));
            }
        });
    });
});
