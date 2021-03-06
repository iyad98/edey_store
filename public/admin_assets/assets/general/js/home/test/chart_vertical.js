var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var color = Chart.helpers.color;

var ctx = document.getElementById('users_statistic').getContext('2d');
window.myBar = new Chart(ctx, {
    type: 'bar',
    data: users_statistic.chart_area,
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'المستخدمين'
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

/*
document.getElementById('randomizeData').addEventListener('click', function() {
    var zero = Math.random() < 0.2 ? true : false;
    barChartData.datasets.forEach(function(dataset) {
        dataset.data = dataset.data.map(function() {
            return zero ? 0.0 : randomScalingFactor();
        });

    });
    window.myBar.update();
});

var colorNames = Object.keys(window.chartColors);
document.getElementById('addDataset').addEventListener('click', function() {
    var colorName = colorNames[barChartData.datasets.length % colorNames.length];
    var dsColor = window.chartColors[colorName];
    var newDataset = {
        label: 'Dataset ' + (barChartData.datasets.length + 1),
        backgroundColor: color(dsColor).alpha(0.5).rgbString(),
        borderColor: dsColor,
        borderWidth: 1,
        data: []
    };

    for (var index = 0; index < barChartData.labels.length; ++index) {
        newDataset.data.push(randomScalingFactor());
    }

    barChartData.datasets.push(newDataset);
    window.myBar.update();
});

document.getElementById('addData').addEventListener('click', function() {
    if (barChartData.datasets.length > 0) {
        var month = MONTHS[barChartData.labels.length % MONTHS.length];
        barChartData.labels.push(month);

        for (var index = 0; index < barChartData.datasets.length; ++index) {
            // window.myBar.addData(randomScalingFactor(), index);
            barChartData.datasets[index].data.push(randomScalingFactor());
        }

        window.myBar.update();
    }
});

document.getElementById('removeDataset').addEventListener('click', function() {
    barChartData.datasets.pop();
    window.myBar.update();
});

document.getElementById('removeData').addEventListener('click', function() {
    barChartData.labels.splice(-1, 1); // remove the label first

    barChartData.datasets.forEach(function(dataset) {
        dataset.data.pop();
    });

    window.myBar.update();
});
*/