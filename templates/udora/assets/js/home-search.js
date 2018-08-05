/* Autocomplete and Home Search */

$("select").on("rendered.bs.select", function () {
        $('head').append($('<link rel="stylesheet" type="text/css">').attr('href', 'css/bootstrap-select.min.css'));
});

$(".dropdown-button").click(function() {
        $(".search-form").toggle();
});


    $('input[name="daterange-home"]').daterangepicker({
          "ranges": {
        'Today': [moment(), moment()],
        'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
        'This Month': [moment().add('month'), moment().endOf('month')],
        'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
    },
    "linkedCalendars": false,
    "showCustomRangeLabel": false,
    "alwaysShowCalendars": false,
    "startDate": "12/10/2016",
    "endDate": "12/31/2016",
    "opens": "center",
    "drops": "up"
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });