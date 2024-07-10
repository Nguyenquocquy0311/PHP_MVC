<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/public/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            margin: 0;
            background-color: #f4f4f4;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: white;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px;
            margin: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            text-align: center;
        }

        .sidebar ul li a {
            text-decoration: none;
        }

        .sidebar ul li:hover {
            cursor: pointer;
            color: #06c9bc;
        }

        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background-color: #f0ebeb;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            height: 60px;
            background-color: white;
            margin-top: 0;
            /* display: none; */
        }

        .header h3 {
            text-align: right;
            padding-right: 10px;
        }

        .table {
            padding-top: 8px;
            margin: 0 auto;
            width: 80%;
        }

        table,
        tr,
        td {
            padding: 16px;
            border-collapse: collapse;
            border-bottom: 1px solid black;
            background-color: white;
        }

        table {
            margin: auto;
            border-radius: 8px;
            box-shadow: 4px 6px 6px rgba(0, 0, 0, 0.3);
        }

        table th {
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
        }

        table td {
            text-align: left;
        }

        .total-row {
            justify-content: space-between;
            background-color: #f0f0f0;
        }

        .total-row td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .total-row .total-label {
            font-weight: bold;
        }

        .total-row .total-count {
            text-align: left;
            flex: 1;
        }

        .action {
            background-color: white;
            border: none;
        }

        .action:hover {
            color: blue;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
        }

        .chart-form {
            display: flex;
            justify-content: center;
        }

        .chart {
            max-width: 420px;
            max-height: 360px;
            background-color: white;
            margin: 10px;
            border-radius: 4px;
        }

        .form-add {
            width: 420px;
            height: 360px;
            background-color: white;
            margin: 10px;
            padding: 0 10px;
            border-radius: 4px;
        }

        .form-add h2 {
            margin-bottom: 20px;
        }

        .form-add input {
            width: 90%;
            padding: 20px;
            margin: 10px 0;
            background-color: #f0efed;
            border: none;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .form-add button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            margin-right: 20px;
            border-radius: 7px;
            font-weight: bold;
        }

        .form-add button:hover {
            background-color: #ff8c1a;
        }

        .form-edit {
            width: 420px;
            height: 360px;
            background-color: white;
            margin: 10px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 4px;
        }

        .form-edit h4 {
            margin-bottom: 12px;
        }

        .form-edit input {
            width: 90%;
            padding: 10px;
            margin: 4px 0;
            background-color: #f0efed;
            border: none;
            border-radius: 5px;
        }

        .form-edit button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-top: 8px;
            margin-right: 20px;
            border-radius: 7px;
            font-weight: bold;
        }

        .form-edit button:hover {
            background-color: #ff8c1a;
        }

        .footer {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Device Management</h2>
        <ul>
            <li style="color: #06c9bc;">Dashboard</li>
            <li><a href="/my_project/my_mvc_project/app/views/logs.php" style="text-decoration: none; color: black">Logs</a></li>
            <li><a href="/my_project/my_mvc_project/app/views/setting.php" style="text-decoration: none; color: black">Settings</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h3>Welcome <?php echo $username ?></h3>
        </div>
        <div class="main">
            <div class="table">
                <table>
                    <tr>
                        <th>Devices</th>
                        <th>MAC Address</th>
                        <th>IP</th>
                        <th>Create Date</th>
                        <th>Power Consumption (Kw/H)</th>
                        <th>Action</th>
                    </tr>
                    <?php require_once '../controllers/DeviceController.php' ?>
                    <?php foreach ($devices as $device) : ?>
                        <tr>
                            <td><?php echo $device['name']; ?></td>
                            <td><?php echo $device['mac_address']; ?></td>
                            <td><?php echo $device['ip']; ?></td>
                            <td><?php echo $device['create_date']; ?></td>
                            <td><?php echo $device['powerConsumption']; ?></td>
                            <td>
                                <button class="action">Edit</button> | <button class="action">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php
                    $totalPowerConsumption = 0;
                    foreach ($devices as $device) {
                        $totalPowerConsumption += $device['powerConsumption'];
                    }
                    ?>
                    <tr class="total-row">
                        <td colspan="5" class="total-label">Total</td>
                        <td class="total-count" style="font-weight: bold;"><?php echo $totalPowerConsumption; ?></td>
                    </tr>
                </table>
            </div>
            <div class="chart-form">
                <canvas id="myDoughnutChart" class="chart" width="400px" height="350px"></canvas>
                <div class="form-add">
                    <h2>ADD FORM</h2>
                    <form method="POST" action="">
                        <input type="text" id="name" name="name" required placeholder="Name">
                        <br>
                        <input type="string" id="mac-address" name="mac-address" required placeholder="Mac Address">
                        <br>
                        <input type="string" id="ip" name="ip" required placeholder="IP">
                        <br>
                        <div class="footer">
                            <button type="submit">ADD DEVICE</button>
                        </div>
                    </form>
                    <?php if (isset($error)) : ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                </div>


                <div class="form-edit" style="display: none;">
                    <h4>EDIT FORM</h4>
                    <form method="POST" action="">
                        <label for="name">Device name</label>
                        <input type="text" id="name" name="name" required placeholder="Name">
                        <br>
                        <label for="mac-address">Mac address</label>
                        <input type="string" id="mac-address" name="mac-address" required placeholder="Mac address">
                        <br>
                        <label for="ip">IP address</label>
                        <input type="string" id="ip" name="ip" required placeholder="IP">
                        <br>
                        <label for="power-consumption">Power consumption</label>
                        <input type="number" id="power-consumption" name="power-consumption" required placeholder="Power consumption">
                        <br>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                    <?php if (isset($_GET['error'])) : ?>
                        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        var devices = <?php echo json_encode($devices); ?>;

        var deviceNames = devices.map(device => device.name);
        var powerConsumptions = devices.map(device => device.powerConsumption);

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
                        'rgba(54, 100, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 100, 235, 1)',
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
    </script>
</body>

</html>