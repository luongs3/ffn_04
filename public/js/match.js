jQuery(function ($) {
    $('.date-time').datetimepicker();
});

$('#season_id, #team1_id, #team2_id').click(function () {
    if ($('#league_id').find(':selected').val() == '') {
        alert($(this).data('alert'));
        return false;
    }
});

$('#league_id').change(function () {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax-seasons?league_id=' + $(this).val(),
        success: function (data) {
            var seasons = $('#season_id');
            var placeHolder = $('#btn-back').data('placeholders');
            seasons.empty().append('<option value="">' + placeHolder['choose_one'] + '</option>');
            for (i = 0; i < data.length; i++) {
                seasons.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
            seasons.trigger('chosen:updated');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/admin/ajax-teams?league_id=' + $(this).val(),
        success: function (data) {
            $('.teams').map(function () {
                var placeHolder = $('#btn-back').data('placeholders');
                $(this).empty().append('<option value="">' + placeHolder['choose_one'] + '</option>');
                for (i = 0; i < data.length; i++) {
                    $(this).append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
                $(this).trigger('chosen:updated');
            });
        }
    })
});
