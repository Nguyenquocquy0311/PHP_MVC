<?php
require_once '../../config/config.php';
require_once '../models/User.php';

$userModel = new User($connect);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $userId;

    if ($userModel->updateUser($id, $username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['success'] = "Update profile success !!!";
        header('location: ../views/setting.php');
        exit();
    } else {
        $error = "Lỗi khi cập nhật thông tin người dùng";
        header('Location: ../views/setting.php?error=' . urlencode($error));
        exit();
    }
}
