<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
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

        .header-main {
            display: flex;
            align-items: center;
            width: 80%;
        }

        .header-main h2 {
            flex: 1;
        }

        .search {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 10px;
        }

        button:hover {
            background-color: #ff8c1a;
        }

        .table {
            width: 80%;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 6px;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .total-row {
            justify-content: space-between;
            background-color: #f0f0f0;
        }

        .total-row td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .total-row .total-label {
            font-weight: bold;
        }

        .total-row .total-count {
            text-align: center;
            flex: 1;
            font-weight: bold;
        }

        .page {
            padding: 10px;
            margin: 10px;
            border-radius: 100px;
            background-color: #3483eb;
            color: white;
            text-decoration: none;
        }

        .page:hover {
            background-color: #6983ec;
        }

        .pagination {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Device Management</h2>
        <ul>
            <li><a href="/my_project/my_mvc_project/app/views/dashboard.php" style="text-decoration: none; color: black">Dashboard</a></li>
            <li style="color: #06c9bc;">Logs</li>
            <li><a href="/my_project/my_mvc_project/app/views/setting.php" style="text-decoration: none; color: black">Settings</a></li>
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
                        <tr>
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
                    <a class="page" href="?page=<?php echo $page; ?>" class="<?php if ($currentPage == $page) echo 'active'; ?>">
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>

</html>