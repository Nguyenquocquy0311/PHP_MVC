<?php
require_once '../../config/config.php';
require_once '../models/DeviceModel.php';

$deviceModel = new DeviceModel($connect);

// Kiểm tra nếu có dữ liệu gửi lên từ form thêm thiết bị
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['mac-address'], $_POST['ip'])) {
        $name = $_POST['name'];
        $macAddress = $_POST['mac-address'];
        $ip = $_POST['ip'];
        $powerConsumption = isset($_POST['power-consumption']) ? $_POST['power-consumption'] : 0;

        if (isset($_POST['id'])) {
            // Cập nhật thiết bị
            $id = $_POST['id'];
            if ($deviceModel->updateDevice($id, $name, $macAddress, $ip, $powerConsumption)) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                return;
            } else {
                $error = "Lỗi khi cập nhật thiết bị";
            }
        } else {
            // Thêm thiết bị
            if ($deviceModel->addDevice($name, $macAddress, $ip, $powerConsumption)) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                return;
            } else {
                $error = "Lỗi khi thêm thiết bị";
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_id'])) {
    // Xóa thiết bị
    $id = $_GET['delete_id'];
    if ($deviceModel->deleteDevice($id)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        return;
    } else {
        $error = "Lỗi khi xóa thiết bị";
    }
}

$limit = 4;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$totalDevices = $deviceModel->getTotalDevices();
$totalPages = ceil($totalDevices / $limit);

$devices = $deviceModel->getDevicesWithPagination($start, $limit);
