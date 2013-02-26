(function() {

    /*
     * Dashboard user
     */

    $('#dashboard-user').change(function() {
        var value = $(this).find('option:selected').attr('value');
        location = 'ext_dashboard.php?user='+ encodeURIComponent(value);
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

    /*
     * XHR and charts
     */

    google.load('visualization', '1', {packages:['corechart']});

    google.setOnLoadCallback(function() {

        

        /*
         * Chart types
         *
         * Each chart type is an object containing settings used to generate
         * the XHR and the appropriate chart.
         */

        var chartTypes = {

            roomUsage: {
                object: google.visualization.PieChart
            },

            entriesNb: {
                object: google.visualization.LineChart,
                additionalInputs: ['chart-period']
            }

        };

        /*
         * Bindings and XHR
         */

        form.find('[type="submit"]').click(function(event) {

            event.preventDefault();

            var selectedChart = form.find('select[name="chart-type"] option:selected'),
                chartName = selectedChart.attr('value'),
                chartType = chartTypes[chartName],
                data = {};
            
            // If there's no additional input, we create the property. In the two cases, we add "chart-start" and "chart-end".
            chartType.additionalInputs = chartType.additionalInputs || [];
            chartType.additionalInputs.push('chart-start', 'chart-end');

            // Retrieves all the data (including "chart-start" and "chart-end") and stores it in an object
            for(var i = 0, input ; input = chartType.additionalInputs[i++] ;) {
                data[input] = form.find('[name="'+ input +'"]').attr('value');
            }

            // Retrieves some complementary informations and adds them to the data object
            data['user'] = $('#dashboard-user option:selected').attr('value');
            data['chart-type'] = chartName;

            $.ajax({
                url: '/ext_charts_xhr.php',
                dataType: 'json',
                data: data,

                success: function(data) {
                    var chart = new chartType.object(document.getElementById('chart'));

                    data = google.visualization.arrayToDataTable(data);

                    // Some options need to be rewritten to avoid visual issues
                    var options = chartType.options = chartType.options || {};
                    options.title = selectedChart.html();
                    options.backgroundColor = '#e7ebee';
                    options.height = 400;

                    chart.draw(data, options);
                }
            });

        });

    });

})();