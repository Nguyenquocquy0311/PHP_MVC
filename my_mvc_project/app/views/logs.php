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
    <title>Logs</title>
    <link rel="stylesheet" href="../../public/css/log.css">
</head>

<body>
    <div class="sidebar">
        <h2>Device Management</h2>
        <ul>
            <li><a href="/my_project/my_mvc_project/app/views/dashboard.php" style="text-decoration: none; color: black">Dashboard</a></li>
            <li style="color: #06c9bc;">Logs</li>
            <li><a href="/my_project/my_mvc_project/app/views/setting.php" style="text-decoration: none; color: black">Settings</a></li>
            <li><button class="logout-btn" onclick="showLogoutModal()">Logout</button></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h3>Welcome <?php echo $username ?></h3>
        </div>
        <div class="main">
            <div class="header-main">
                <h2>Action Logs</h2>
                <div class="search">
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="table">
                <table>
                    <tr>
                        <th>Device ID</th>
                        <th>Name</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                    <?php
                    require_once '../controllers/LogController.php';

                    foreach ($logs as $log) : ?>
                        <tr onclick="showDeviceModal('<?php echo $log['device_name']; ?>', '<?php echo $log['action']; ?>', '<?php echo $log['id']; ?>')">
                            <td><?php echo $log['id']; ?></td>
                            <td><?php echo $log['device_name']; ?></td>
                            <td><?php echo $log['action']; ?></td>
                            <td><?php echo $log['date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="3" class="total-label">Total</td>
                        <td class="total-count"><?php echo count($logs) * $totalPages; ?></td>
                    </tr>
                </table>
            </div>
            <div class="pagination">
                <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                    <a class="page <?php if ($currentPage == $page) echo 'active'; ?>" href="?page=<?php echo $page; ?>">
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div id="logoutModal" class="modal" style="display: none;">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <button class="confirm-btn" onclick="confirmLogout()">Confirm</button>
            <button class="cancel-btn" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>

    <div id="deviceModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3 id="deviceName"></h3>
            <p id="deviceAction"></p>
            <form id="toggleForm" method="POST" action="../controllers/LogController.php">
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" id="device_id" name="device_id">
                <input type="hidden" id="new_action" name="new_action">
                <button type="submit" class="toggle-action-btn">Toggle Action</button>
            </form>
            <button class="cancel-btn" onclick="closeDeviceModal()">Close</button>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').style.display = 'block';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function confirmLogout() {
            window.location.href = '/my_project/my_mvc_project/app/views/logout.php';
        }

        function showDeviceModal(name, action, id) {
            document.getElementById('deviceName').innerText = name;
            document.getElementById('deviceAction').innerText = action;
            document.getElementById('device_id').value = id;
            document.getElementById('new_action').value = (action === 'Turned on') ? 'Turned off' : 'Turned on';
            document.getElementById('deviceModal').style.display = 'block';
        }

        function closeDeviceModal() {
            document.getElementById('deviceModal').style.display = 'none';
        }
    </script>
</body>

</html>