$(document).ready(function(){
    $('.switcher').click(function () {
        var id = $(this).attr('id');
        //chart.showLoading('Getting stat data ....');
        if (id == "1") {
        $.getJSON("history_data1.php", function(data) {
            chart1 = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'areaspline',
                    height: 350,
                    zoomType: 'xy'
                },
                title: {
                    text: 'Monitoring For Outlet 1'
                    },
                subtitle: {
                    text: 'In Past 7 Days'
                },
                plotOptions: {
                    column: {
                        depth: 25
                    }
                },
                xAxis: {
                    categories: ['Sunday', 'Monday', 'Tuesday','Wednesday', 'Thursday', 'Friday','Saturday']
                },
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value} USD',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: 'Budget',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true

                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Power',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} KWH',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }],    
                tooltip: {
                     formatter: function() {
                       return '<b>'+ this.series.name +'</b><br/>'+
                       this.x +': '+ this.y;
                     },            
                 },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 120,
                    verticalAlign: 'top',
                    y: 60,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                    },
                series: [{                
                        name: 'Budget',
                        yAxis: 0,
                        data: data[0].data,
                    }, {                
                        name: 'Power',
                        yAxis: 1,
                        data: data[1].data
                    }]
                });    
            });    
        }else if (id == "2"){
        $.getJSON("history_data2.php", function(data) {
        chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            type: 'areaspline',
            height: 350,
        },
        title: {
            text: 'Monitoring For Outlet 2'
            },
            subtitle: {
                text: 'In Past 7 Days'
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
        xAxis: {
            categories: ['Sunday', 'Monday', 'Tuesday','Wednesday', 'Thursday', 'Friday','Saturday']
        },
        yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value} USD',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: 'Budget',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true

                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Power',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} KWH',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }],    
        tooltip: {
             formatter: function() {
               return '<b>'+ this.series.name +'</b><br/>'+
               this.x +': '+ this.y;
             }
            
         },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 60,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
        series: [{                
            name: 'Budget',
            yAxis: 0,
            data: data[0].data,
            }, {                
            name: 'Power',
            yAxis: 1,
            data: data[1].data
            }]
        });    
        });     
        }else if (id == "3"){
            $.getJSON("history_data3.php", function(data) {
            chart1 = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'areaspline',
                height: 350,
            },
            title: {
                text: 'Monitoring For Outlet 3'
                },
                subtitle: {
                    text: 'In Past 7 Days'
                },
                plotOptions: {
                    column: {
                        depth: 25
                    }
                },
            xAxis: {
                categories: ['Sunday', 'Monday', 'Tuesday','Wednesday', 'Thursday', 'Friday','Saturday']
            },
            yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value} USD',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: 'Budget',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true

                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Power',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} KWH',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }],    
            tooltip: {
                 formatter: function() {
                   return '<b>'+ this.series.name +'</b><br/>'+
                   this.x +': '+ this.y;
                 }
             },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 120,
                    verticalAlign: 'top',
                    y: 60,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
               series: [{                
                    name: 'Budget',
                    yAxis: 0,
                    data: data[0].data,
                }, {                
                    name: 'Power',
                    yAxis: 1,
                    data: data[1].data
                    }]
                });    
            });    
        }    
    });
});