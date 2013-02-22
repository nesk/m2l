/*
 * Dashboard user
 */

$('#dashboard-user').change(function() {
    var value = $(this).find('option:selected').attr('value');
    location = 'ext_user_stats.php?user='+ encodeURIComponent(value);
});

/*
 * Forms
 */

var form = $('#chart-form');

$('#chart-blocks span').hide();

form.find('[name="chart-type"]').change(function() {
    $('#chart-blocks span').hide();

    var value = $(this).find('option:selected').attr('value');
    $('#chart-blocks-'+ value).show();
});

/*
 * Datepicker
 */

form.find('[name="chart-start"], [name="chart-end"]').datepicker();