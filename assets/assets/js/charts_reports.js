var piechart;
var barchart;
var linechart;
var old_barData;
var old_lineData;
var old_pieData;


function pieChart(chartData, chartMainTitle, styleParams) {
    old_pieData = chartData;
    document.write('<div id="piecontainer" style="' + styleParams + '; display:none;" align="center"></div>');
    var cls = $("#pie").attr("class");
    if (cls == 'red_bg w100 white') {
        $("#piecontainer").show();
    }

    $(function () {

        $(document).ready(
                function () {
                    piechart = new Highcharts.Chart({
                        
                        chart: {
                           
                            renderTo: 'piecontainer',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        
                        title: {
                            text: chartMainTitle
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.point.name + '</b>: '
                                        + this.y + '%';
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                                type: 'pie',
                                data: chartData
                            }]
                    });
                     
       
                });
               
    });
}

function barChart(chartData, chartXDataTitle, chartMainTitle, chartXMainTitle, chartYMainTitle, styleParams) {

    old_barData = chartData;
    document.write('<div id="barcontainer" style="' + styleParams + '; display:none;" align="center"></div>');
    var cls = $("#bar").attr("class");
    if (cls == 'red_bg w100 white') {
        $("#barcontainer").show();
    }
    $(function () {

        $(document).ready(
                function () {
                    barchart = new Highcharts.Chart({
                        chart: {
                            type: 'column',
                            renderTo: 'barcontainer',
                        },
                        title: {
                            text: chartMainTitle
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.point.name + '</b>: '
                                        + this.y.toFixed(2) + '%';
                            }
                        },
                        xAxis: {
                            categories: chartXDataTitle,
                            title: {
                                text: chartXMainTitle
                            }
                        },
                        yAxis: {
                            title: {
                                text: chartYMainTitle,
                                align: 'middle'
                            }
                        },
                        plotOptions: {
                            column: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true
                                },
                                showInLegend: false
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            x: -100,
                            y: 100,
                            floating: true,
                            borderWidth: 1,
                            backgroundColor: '#FFFFFF',
                            shadow: true
                        },
                        series: [{
                                data: chartData
                            }]
                    });
                });
    });
}

function lineChart(chartData, chartXDataTitle, chartMainTitle, chartXMainTitle, chartYMainTitle, styleParams) {
    old_lineData = chartData;
    document.write('<div id="linecontainer" style="' + styleParams + ';display:none;" align="center"></div>');
    var cls = $("#line").attr("class");
    if (cls == 'red_bg w100 white') {
        $("#linecontainer").show();
    }
    $(function () {

        $(document).ready(
                function () {
                    linechart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'linecontainer'
                        },
                        title: {
                            text: chartMainTitle
                        },
                        xAxis: {
                            categories: chartXDataTitle,
                            title: {
                                text: chartXMainTitle
                            }
                        },
                        yAxis: {
                            type: 'logarithmic',
                            minorTickInterval: 0.1,
                            title: {
                                text: chartYMainTitle
                            }
                        },
                        plotOptions: {
                            line: {
                                showInLegend: false
                            }
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.x + '</b>: '
                                        + this.y.toFixed(2) + '%';
                            }
                        },
                        series: [{
                                data: chartData
                            }]
                    });
                });
    });
}

function getCharts(pie, bar, line, displayFirst, pieAndBarChartData, lineChartDatas, barAndLineChartXDataTitle, chartMainTitle, styleParams, chartXMainTitle, chartYMainTitle) {


    var str = '<div align="center">';
    var other = '';
    if (displayFirst == '') {
        displayFirst = 'pie';
    }

    first = displayFirst;
    if ((pie == 1 && bar == 1 && line == 0) && (displayFirst == 'pie' || displayFirst == 'line')) {
        first = 'pie';
    }

    if ((pie == 1 && bar == 0 && line == 1) && (displayFirst == 'bar' || displayFirst == 'pie')) {
        first = 'pie';
    }

    if ((pie == 0 && bar == 0 && line == 1) && (displayFirst == 'bar' || displayFirst == 'pie')) {
        first = 'line';
    }

    if ((pie == 1 && bar == 0 && line == 0) && (displayFirst == 'bar' || displayFirst == 'line')) {
        first = 'pie';
    }

    if ((pie == 0 && bar == 1 && line == 0) && (displayFirst == 'pie' || displayFirst == 'line')) {
        first = 'bar';
    }

    if ((pie == 0 && bar == 1 && line == 1) && (displayFirst == 'pie')) {
        first = 'bar';
    }

    if (line == 1 && displayFirst == 'line') {
        first = 'line';
    }
    if (pie == 1 && displayFirst == 'pie') {
        first = 'pie';
    }
    if (bar == 1 && displayFirst == 'bar') {
        first = 'bar';
    }

    displayFirst = first;

    if (pie != '0') {
        if (displayFirst == 'pie') {
            classFirst = 'red_bg w100 white';
        } else {
            classFirst = 'blue_bg w100 white calendar_cursor';
        }

        pieChartData = '<div class="' + classFirst + '" onclick="showPie()" id="pie" style="display:inline-block; height: 35px;" align="center"><div style="height:10px;"></div>Pie Chart</span></div>&nbsp;';
        if (displayFirst == 'pie') {
            str += pieChartData;
        } else {
            other += pieChartData;
        }
    }
    if (bar != "0") {
        if (displayFirst == 'bar') {
            classFirst = 'red_bg w100 white';
        } else {
            classFirst = 'blue_bg w100 white calendar_cursor';
        }
        barChartData = '<div class="' + classFirst + '" onclick="showBar()" id="bar" style="display:inline-block; height: 35px;" align="center"><div style="height:10px;"></div>Bar Chart</span></div>&nbsp;';
        if (displayFirst == 'bar') {
            str += barChartData;
        } else {
            other += barChartData;
        }
    }
    if (line != "0") {
        if (displayFirst == 'line') {
            classFirst = 'red_bg w100 white';
        } else {
            classFirst = 'blue_bg w100 white calendar_cursor';
        }
        lineChartData = '<div class="' + classFirst + '" onclick="showLine()" id="line" style="display:inline-block; height: 35px;" align="center"><div style="height:10px;"></div>Line Chart</span></div>&nbsp;';
        if (displayFirst == 'line') {
            str += lineChartData;
        } else {
            other += lineChartData;
        }
    }
    str += other;
    str += '</div><div class="c10"></div>';
    document.write(str);
    if (pie == 1) {
        pieChart(pieAndBarChartData, chartMainTitle, styleParams);
    }
    if (bar == 1) {
        barChart(pieAndBarChartData, barAndLineChartXDataTitle, chartMainTitle, chartXMainTitle, chartYMainTitle, styleParams);
    }
    if (line == 1) {
        lineChart(lineChartDatas, barAndLineChartXDataTitle, chartMainTitle, chartXMainTitle, chartYMainTitle, styleParams);
    }
}


function showPie() {
    $("#barcontainer").hide();
    $("#linecontainer").hide();
    $("#piecontainer").css("display", "block");
    $("#bar").attr("class", "blue_bg w100 white calendar_cursor");
    $("#line").attr("class", "blue_bg w100 white calendar_cursor");
    $("#pie").attr("class", "red_bg w100 white");

    //piechart.setSize($("#piecontainer").width() / 2, piechart.height, doAnimation = true);

    piechart.series[0].setData(old_pieData, true);

}

function showBar() {
    $("#linecontainer").hide();
    $("#piecontainer").hide();
    $("#barcontainer").css("display", "block");
    $("#bar").attr("class", "red_bg w100 white");
    $("#line").attr("class", "blue_bg w100 white calendar_cursor");
    $("#pie").attr("class", "blue_bg w100 white calendar_cursor");


    // barchart.setSize(1252, 400, doAnimation = true);
     barchart.series[0].setData(old_barData, true);



}

function showLine() {
    $("#barcontainer").hide();
    $("#piecontainer").hide();
    $("#linecontainer").css("display", "block");
    $("#bar").attr("class", "blue_bg w100 white calendar_cursor");
    $("#line").attr("class", "red_bg w100 white");
    $("#pie").attr("class", "blue_bg w100 white calendar_cursor");

    linechart.series[0].setData(old_lineData, true);

}





