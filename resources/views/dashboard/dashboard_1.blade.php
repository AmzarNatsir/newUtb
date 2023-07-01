<style>
    .highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>
<figure class="highcharts-figure">
    <div id="container_best_selling"></div>
</figure>
<script>
    var lastColor;
    function getRandColor(same, darkness) {
        //6 levels of brightness from 0 to 5, 0 being the darkest
        var rgb = [];
        if(same && lastColor) {
            rgb = lastColor;
        } else {
            rgb = [Math.random() * 256, Math.random() * 256, Math.random() * 256];
        }
        var mix = [darkness * 51, darkness * 51, darkness * 51]; //51 => 255/5
        var mixedrgb = [rgb[0] + mix[0], rgb[1] + mix[1], rgb[2] + mix[2]].map(function (x) {
            return Math.round(x / 2.0)
        })
        lastColor = rgb;
        return "rgb(" + mixedrgb.join(",") + ")";
    }
    var produk_name = <?php echo json_encode($top_ten_name) ?>;
    var data = <?php echo json_encode($top_ten_value) ?>;
    var periode = <?php echo json_encode($periode) ?>;
    Highcharts.chart('container_best_selling', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Produk Terlaris Periode '+periode
        },
        subtitle: {
            text: 'PT. Usaha Tani Bersama'
        },
        xAxis: {
            categories: produk_name,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        
        series: [{
            showInLegend: false,
            data: data,
            color: getRandColor(false,5),
            borderColor: getRandColor(true,3),
            borderWidth: 2,
        }
        ]
    });
</script>