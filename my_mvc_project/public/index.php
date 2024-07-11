<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: /my_project/my_mvc_project/app/views/login.php');
    exit();
}

header('Location: /my_project/my_mvc_project/app/views/dashboard.php');
exit();
