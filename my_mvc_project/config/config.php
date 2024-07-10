<?php
$connect = mysqli_connect('localhost', 'root', '', 'my_mvc_project');

if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
