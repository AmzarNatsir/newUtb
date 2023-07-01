<div id="container_2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
$(function () {
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
    var data = <?php echo json_encode($data_penjualan) ?>;
    var periode = <?php echo $periode ?>;
    $('#container_2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Penjualan Periode '+periode
        },
        subtitle: {
            text: 'PT. Usaha Tani Bersama'
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ],
            crosshair: true
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
            //color: 'rgba(220,0,220,0.5)',
            color: getRandColor(false,5),
            //borderColor: 'rgba(50,40,20,1)',
            borderColor: getRandColor(true,3),
            borderWidth: 2,
        }]
    });
});
</script>