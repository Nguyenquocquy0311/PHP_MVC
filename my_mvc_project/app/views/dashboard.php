<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="sidebar">
        <h2>Device Management</h2>
        <ul>
            <li style="color: #06c9bc;">Dashboard</li>
            <li><a href="/my_project/my_mvc_project/app/views/logs.php" style="text-decoration: none; color: black">Logs</a></li>
            <li><a href="/my_project/my_mvc_project/app/views/setting.php" style="text-decoration: none; color: black">Settings</a></li>
            <li><button class="logout-btn" onclick="showLogoutModal()">Logout</button></li>
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
                                <button class="action" onclick="editDevice(<?php echo $device['id']; ?>)">Edit</button>
                                <button class="action" onclick="showDeleteModal(<?php echo $device['id']; ?>)">Delete</button>
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
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?php echo $i; ?>" class="page"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="chart-form">
                <canvas id="myDoughnutChart" class="chart" width="400px" height="350px"></canvas>
                <div class="form-add">
                    <h2 id="form-title">ADD FORM</h2>
                    <form method="POST" action="">
                        <input type="hidden" id="id" name="id">
                        <input type="text" id="name" name="name" required placeholder="Name">
                        <br>
                        <input type="text" id="mac-address" name="mac-address" required placeholder="Mac Address" pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$" title="Enter a valid MAC address (e.g., 00:1A:2B:3C:4D:5E)">
                        <br>
                        <input type="text" id="ip" name="ip" required placeholder="IP" pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$" title="Enter a valid IP address (e.g., 192.168.0.1)">
                        <br>
                        <input type="number" id="power-consumption" name="power-consumption" required placeholder="Power Consumption">
                        <br>
                        <div class="footer">
                            <button type="submit">SAVE DEVICE</button>
                            <button type="button" id="cancel-edit" onclick="cancelEdit()" style="display:none;">CANCEL</button>
                        </div>
                    </form>
                    <?php if (isset($error)) : ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this device?</p>
            <button class="confirm-btn" onclick="confirmDelete()">Confirm</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <button class="confirm-btn" onclick="confirmLogout()">Confirm</button>
            <button class="cancel-btn" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>

    <script>
        var devices = <?php echo json_encode($devices); ?>;
        var deviceNames = devices.map(device => device.name);
        var powerConsumptions = devices.map(device => device.powerConsumption);
        var deleteDeviceId = null;

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

        function editDevice(id) {
            var device = devices.find(d => d.id == id);
            document.getElementById('id').value = device.id;
            document.getElementById('name').value = device.name;
            document.getElementById('mac-address').value = device.mac_address;
            document.getElementById('ip').value = device.ip;
            document.getElementById('power-consumption').value = device.powerConsumption;
            document.getElementById('form-title').innerText = "EDIT FORM";
            document.getElementById('cancel-edit').style.display = "inline-block";
        }

        function cancelEdit() {
            document.getElementById('id').value = "";
            document.getElementById('name').value = "";
            document.getElementById('mac-address').value = "";
            document.getElementById('ip').value = "";
            document.getElementById('power-consumption').value = "";
            document.getElementById('form-title').innerText = "ADD FORM";
            document.getElementById('cancel-edit').style.display = "none";
        }

        function showDeleteModal(id) {
            deleteDeviceId = id;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            window.location.href = '?delete_id=' + deleteDeviceId;
        }

        function showLogoutModal() {
            document.getElementById('logoutModal').style.display = 'block';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function confirmLogout() {
            window.location.href = '/my_project/my_mvc_project/app/views/logout.php';
        }
    </script>
</body>

</html>