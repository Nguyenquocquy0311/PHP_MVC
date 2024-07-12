<?php
session_start();
require_once '../../config/config.php';
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $userModel = new User($connect);
    $user = $userModel->getUserByUsername($username);

    if ($user && $password == $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['password'] = $password;
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../views/dashboard.php');
        exit();
    } else {
        header('Location: ../views/login.php?error=Invalid username or password.');
        exit();
    }
} else {
    header('Location: ../views/login.php');
    exit();
}
