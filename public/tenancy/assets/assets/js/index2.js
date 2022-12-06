$(function (e) {
    'use strict';
    console.log(sum);
    /*-----echart-----*/
    var chartdata3 = [
        {
            name: 'Value',
            type: 'bar',
            barMaxWidth: 30,
            data: sum,
            itemStyle: {
                normal: {
                    // barBorderRadius: [50, 50, 0, 0] ,
                }
            }
        }
    ];

    var option5 = {
        grid: {
            top: '6',
            right: '0',
            bottom: '17',
            left: '35',
        },
        tooltip: {
            show: true,
            showContent: true,
            alwaysShowContent: true,
            triggerOn: 'mousemove',
            trigger: 'axis',
            axisPointer:
            {
                label: {
                    show: true,
                }
            }

        },
        xAxis: {
            data: category,
            axisLine: {
                lineStyle: {
                    color: 'rgba(67, 87, 133, .09)'
                }
            },
            axisLabel: {
                fontSize: 10,
                color: '#8e9cad'
            }
        },
        yAxis: {
            splitLine: {
                lineStyle: {
                    color: 'rgba(67, 87, 133, .09)'
                }
            },
            axisLine: {
                lineStyle: {
                    color: 'rgba(67, 87, 133, .09)'
                }
            },
            axisLabel: {
                fontSize: 10,
                color: '#8e9cad'
            }
        },
        series: chartdata3,
        color:[ '#4454c3', '#f72d66','#cedbfd']
    };
    var chart5 = document.getElementById('myfirstchart');
    var barChart5 = echarts.init(chart5);
    barChart5.setOption(option5);

    /*-----canvasDoughnut-----*/
    if ($('.canvasDoughnut').length){

        var chart_doughnut_settings = {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
                labels: t10Category,
                datasets: [{
                    data: t10Sum,
                    backgroundColor: [
                        "#2dce89",
                        "#4454c3",
                        "#ff5b51",
                        "#FFC300",
                        "#9B59B6",
                        "#7FB3D5",
                        "#EB984E",
                        "#512DA8",
                        "#FFF176",
                        "#fff",
                    ],
                    hoverBackgroundColor: [
                        "#2dce89",
                        "#4454c3",
                        "#ff5b51",
                        "#FFC300",
                        "#9B59B6",
                        "#7FB3D5",
                        "#EB984E",
                        "#512DA8",
                        "#FFF176",
                        "#fff",
                    ]
                }]
            },
            options: {
                legend: false,
                responsive: true,
                cutoutPercentage: 70
            }
        }

        $('.canvasDoughnut').each(function(){

            var chart_element = $(this);
            var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

        });
    }
    /*-----canvasDoughnut-----*/

});
