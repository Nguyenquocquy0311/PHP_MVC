<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../../public/css/setting.css">
</head>

<body>
    <div class="sidebar">
        <h2>Device Management</h2>
        <ul>
            <li><a href="/my_project/my_mvc_project/app/views/dashboard.php" style="text-decoration: none; color: black">Dashboard</a></li>
            <li><a href="/my_project/my_mvc_project/app/views/logs.php" style="text-decoration: none; color: black">Logs</a></li>
            <li style="color: #06c9bc;">Settings</li>
            <li><button class="logout-btn" onclick="showLogoutModal()">Logout</button></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h3>Welcome <?php echo $username ?></h3>
        </div>
        <div class="main">
            <div class="form">
                <h2>Update profile</h2>
                <form method="POST" action="../controllers/SettingController.php">
                    <input type="text" id="username" name="username" required placeholder="Username" value=<?php echo $username; ?>>
                    <br>
                    <input type="password" id="password" name="password" required placeholder="Password" value=<?php echo $password; ?>>
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

        <div id="logoutModal" class="modal" style="display: none;">
            <div class="modal-content">
                <p>Are you sure you want to logout?</p>
                <button class="confirm-btn" onclick="confirmLogout()">Confirm</button>
                <button class="cancel-btn" onclick="closeLogoutModal()">Cancel</button>
            </div>
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
    </script>
</body>

</html>