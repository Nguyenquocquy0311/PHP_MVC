// public/js/chart.js

// Lấy dữ liệu từ PHP để vẽ biểu đồ
var devices = <?php echo json_encode($devices); ?>;

// Chuẩn bị dữ liệu cho biểu đồ
var deviceNames = devices.map(device => device.name);
var powerConsumptions = devices.map(device => device.powerConsumption);

// Vẽ biểu đồ
var ctx = document.getElementById('myDoughnutChart').getContext('2d');
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: deviceNames,
        datasets: [{
            label: 'Power Consumption (Kw/H)',
            data: powerConsumptions,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Power Consumption (Kw/H)'
            }
        }
    }
});
