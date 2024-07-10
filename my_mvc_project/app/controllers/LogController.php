<?php
require_once '../../config/config.php';
require_once '../models/Log.php';

$logModel = new Log($connect);

$perPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$search = isset($_GET['search']) ? $_GET['search'] : '';

$totalLogs = $logModel->countAllLogs($search);

$totalPages = ceil($totalLogs / $perPage);

$logs = $logModel->getAllLogs(($currentPage - 1) * $perPage, $perPage, $search);

require_once '../views/logs.php';
