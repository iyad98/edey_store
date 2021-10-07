

var financial_config = {
    type: 'line',
    data: financial.chart_area,
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'المبيعات'
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
                    labelString: financial.xAxes
                }
            }],
            yAxes: [{
                stacked: true,
                scaleLabel: {
                    display: true,
                    labelString: financial.yAxes
                }
            }]
        }
    }
};

var financial_ctx = document.getElementById('chart_area').getContext('2d');
window.myLine = new Chart(financial_ctx, financial_config);
/**********************************************************/
var order_status_config = {
    type: 'pie',
    data: orders_type_data.count_orders_type,
    options: {
        responsive: true
    }
};

var order_status_ctx = document.getElementById('chart-pie-order-type').getContext('2d');
window.myPie_order_status = new Chart(order_status_ctx, order_status_config);

/**********************************************************/

var order_count_config = {
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

var order_count_ctx = document.getElementById('chart_area-order-count').getContext('2d');
window.myLine = new Chart(order_count_ctx, order_count_config);

/***************************************************************/
var users_statistic_ctx = document.getElementById('users_statistic').getContext('2d');
window.myBar = new Chart(users_statistic_ctx, {
    type: 'bar',
    data: users_statistic.chart_area,
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'العملاء'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

/*******************************************************************/

var count_users_type_config = {
    type: 'pie',
    data: users_statistic.count_users_type,
    options: {
        responsive: true
    }
};

var count_users_type_ctx = document.getElementById('count_users_type').getContext('2d');
window.myPie = new Chart(count_users_type_ctx, count_users_type_config);


/*******************************************************************/

var count_all_orders_type_config = {
    type: 'pie',
    data: get_orders_payment_types_data.count_all_orders_type,
    options: {
        responsive: true
    }
};

var count_all_order_type_ctx = document.getElementById('count_all_order_payment_types').getContext('2d');
window.myPie_all_orders_type = new Chart(count_all_order_type_ctx, count_all_orders_type_config);

/*******************************************************************/

var count_all_orders_shipping_type_config = {
    type: 'pie',
    data: get_orders_shipping_types_data.count_all_orders_type,
    options: {
        responsive: true
    }
};

var count_all_order_shipping_type_ctx = document.getElementById('count_all_order_shipping_types').getContext('2d');
window.myPie_all_order_shipping_type = new Chart(count_all_order_shipping_type_ctx, count_all_orders_shipping_type_config);
