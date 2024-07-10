<?php
require_once '../../config/config.php';
require_once '../models/User.php';

$userModel = new User($connect);

session_start();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($userModel->updateUser($userId, $username, $password)) {
        header('Location: ../views/settings.php');
        exit;
    } else {
        $error = "Lỗi khi cập nhật thông tin người dùng";
        header('Location: ../views/settings.php?error=' . urlencode($error));
        exit;
    }
}
