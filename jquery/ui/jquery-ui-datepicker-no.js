/* $Id: jquery-ui-datepicker-no.js 1743 2011-01-11 09:47:26Z cimorrison $ */
/* Norwegian initialisation for the jQuery UI date picker plugin. */
/* Modified version of the one written by Naimdjon Takhirov (naimdjon@gmail.com). */
/* Based on input from Pål Monstad */
jQuery(function($){
    $.datepicker.regional['no'] = {
		closeText: 'Lukk',
        prevText: '&laquo;Forrige',
		nextText: 'Neste&raquo;',
		currentText: 'I dag',
        monthNames: ['januar','februar','mars','april','mai','juni',
        'juli','august','september','oktober','november','desember'],
        monthNamesShort: ['jan','feb','mar','apr','mai','jun',
        'jul','aug','sep','okt','nov','des'],
		dayNamesShort: ['søn','man','tir','ons','tor','fre','lør'],
		dayNames: ['søndag','mandag','tirsdag','onsdag','torsdag','fredag','lørdag'],
		dayNamesMin: ['sø','ma','ti','on','to','fr','lø'],
		weekHeader: 'Uke',
        dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['no']);
});
