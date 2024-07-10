<?php
require_once '../../config/config.php';
require_once '../models/DeviceModel.php';

$deviceModel = new DeviceModel($connect);

// Kiểm tra nếu có dữ liệu gửi lên từ form thêm thiết bị
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['mac-address'], $_POST['ip'])) {
    $name = $_POST['name'];
    $macAddress = $_POST['mac-address'];
    $ip = $_POST['ip'];

    // Gọi phương thức thêm thiết bị
    if ($deviceModel->addDevice($name, $macAddress, $ip)) {
        // Nếu thêm thành công, chuyển hướng đến trang hiện tại để làm mới danh sách thiết bị
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Nếu thêm thất bại, hiển thị thông báo lỗi
        $error = "Lỗi khi thêm thiết bị";
    }
}

$devices = $deviceModel->getAllDevices();
