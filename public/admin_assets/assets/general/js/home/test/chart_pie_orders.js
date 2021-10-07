
var config = {
    type: 'pie',
    data: orders_type_data.count_orders_type,
    options: {
        responsive: true
    }
};

var ctx = document.getElementById('chart-pie-order-type').getContext('2d');
window.myPie_order_status = new Chart(ctx, config);

/**********************************************************/

var config2 = {
    type: 'line',
    data: orders_count_data.chart_area,
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'الطلبات'
        },
        tooltips: {
            mode: 'index',
        },
        hover: {
            mode: 'index'
        },
        scales: {
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: orders_count_data.xAxes
                }
            }],
            yAxes: [{
                stacked: true,
                scaleLabel: {
                    display: true,
                    labelString: orders_count_data.yAxes
                }
            }]
        }
    }
};

var ctx2 = document.getElementById('chart_area-order-count').getContext('2d');
window.myLine = new Chart(ctx2, config2);
