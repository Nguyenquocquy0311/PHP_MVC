<?php
require_once '../../config/config.php';
require_once '../models/Log.php';

$logModel = new Log($connect);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle') {
    $deviceId = $_POST['device_id'];
    $newAction = $_POST['new_action'];

    if ($logModel->toggleDeviceAction($deviceId, $newAction)) {
        header('Location: /my_project/my_mvc_project/app/views/logs.php');
        return;
    } else {
        echo "Failed to toggle device action.";
    }
}

$perPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$search = isset($_GET['search']) ? $_GET['search'] : '';

$totalLogs = $logModel->countAllLogs($search);

$totalPages = ceil($totalLogs / $perPage);

$logs = $logModel->getAllLogs(($currentPage - 1) * $perPage, $perPage, $search);

require_once '../views/logs.php';
