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
    <link rel="stylesheet" href="/public/css/styles.css">
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
        }

        .header h3 {
            text-align: right;
            padding-right: 10px;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
        }

        .form {
            background-color: white;
            margin-top: 20px;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            width: 400px;
            height: 360px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            margin-top: 16px;
        }

        button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 20px;
        }

        button:hover {
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
            <li><a href="/my_project/my_mvc_project/app/views/dashboard.php" style="text-decoration: none; color: black">Dashboard</a></li>
            <li><a href="/my_project/my_mvc_project/app/views/logs.php" style="text-decoration: none; color: black">Logs</a></li>
            <li style="color: #06c9bc;">Settings</li>
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
    </div>
</body>

</html>