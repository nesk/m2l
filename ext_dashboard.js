/*
 * Dashboard user
 */

$('#dashboard-user').change(function() {
    var value = $(this).find('option:selected').attr('value');
    location = 'ext_user_stats.php?user='+ encodeURIComponent(value);
});