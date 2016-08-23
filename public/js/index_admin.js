$(document).ready(function () {
    <!-- Flot -->
    var graph = [], i = 0;
    var data = $('.dashboard_graph').data('graph');
    for (var key in data) {
        graph[i] = [gd(data[key]['year'], data[key].month, data[key].day), data[key].number];
        i++;
    }

    $('#canvas_dahs').length && $.plot($('#canvas_dahs'), [
        graph
    ], {
        series: {
            lines: {
                show: false,
                fill: true
            },
            splines: {
                show: true,
                tension: 0.4,
                lineWidth: 1,
                fill: 0.4
            },
            points: {
                radius: 0,
                show: true
            },
            shadowSize: 2
        },
        grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: '#d5d5d5',
            borderWidth: 1,
            color: '#fff'
        },
        colors: ['rgba(38, 185, 154, 0.38)', 'rgba(3, 88, 106, 0.38)'],
        xaxis: {
            tickColor: 'rgba(51, 51, 51, 0.06)',
            mode: 'time',
            tickSize: [1, 'day'],
            //tickLength: 10,
            axisLabel: 'Date',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
        },
        yaxis: {
            ticks: 8,
            tickColor: 'rgba(51, 51, 51, 0.06)',
        },
        tooltip: false
    });

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    <!-- /Flot -->

    <!-- google analytic -->
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-82691717-1', 'auto');
    ga('send', 'pageview');
    <!-- /google analytic -->

    $('select').chosen();
});
