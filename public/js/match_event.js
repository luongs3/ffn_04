$('#season_id').click(function () {
    if ($("#league_id").find(":selected").val() == "") {
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
        url: '/admin/match-events/match-names?season_id=' + $('#season_id').val(),
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

$('#match_id').click(function () {
    if ($("#season_id").find(":selected").val() == "") {
        alert($(this).data('alert'));
        return false;
    }
});

$('#season_id').change(function () {
    $.ajax({
        type: 'GET',
        url: '/admin/match-events/match-names?season_id=' + $(this).val(),
        success: function (data) {
            var match = $('#match_id');
            match.empty().append('<option value="">' + '-- Choose one --' + '</option>');
            for (i = 0; i < data.length; i++) {
                match.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
        }
    })
});
