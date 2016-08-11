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
        url: '/admin/seasons/ajax?league_id=' + $(this).val(),
        success: function (data) {
            var seasons = $('#season_id');
            seasons.empty().append('<option value="">' + '-- Choose one --' + '</option>');
            for (i = 0; i < data.length; i++) {
                seasons.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
        }
    });

    $.ajax({
        type: 'GET',
        url: '/admin/teams/ajax?league_id=' + $(this).val(),
        success: function (data) {
            $('.teams').map(function () {
                $(this).empty().append('<option value="">' + '-- Choose one --' + '</option>');
                for (i = 0; i < data.length; i++) {
                    $(this).append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
            });
        }
    })
});
