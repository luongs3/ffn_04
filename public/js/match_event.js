$('#season_id').click(function () {
    if ($("#league_id").find(":selected").val() == "") {
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
        url: '/admin/seasons/' + $(this).val() + '/matches',
        success: function (data) {
            console.log(data);
            var matches = $('#match_id');
            var placeHolder = $('#btn-back').data('placeholders');
            matches.empty().append('<option value="">' + placeHolder['choose_one'] + '</option>');
            for (i = 0; i < data.length; i++) {
                matches.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
            matches.trigger('chosen:updated');
        }
    })
});
