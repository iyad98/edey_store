
/**********************************************************/
var order_status_config = {
    type: 'pie',
    data: orders_payment_type,
    options: {
        responsive: true
    }
};

var order_status_ctx = document.getElementById('chart-pie-order-type').getContext('2d');
window.myPie_order_status = new Chart(order_status_ctx, order_status_config);

/**********************************************************/

var order_count_config = {
    type: 'line',
    data: chart_orders.chart_area,
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
                    labelString: chart_orders.xAxes
                }
            }],
            yAxes: [{
                stacked: true,
                scaleLabel: {
                    display: true,
                    labelString: chart_orders.yAxes
                }
            }]
        }
    }
};

var order_count_ctx = document.getElementById('chart_area-order-count').getContext('2d');
window.myLine = new Chart(order_count_ctx, order_count_config);

/***************************************************************/
