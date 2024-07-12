<?php

class Log
{
    private $connect;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function getAllLogs($offset, $limit, $search = '')
    {
        if ($search) {
            $search = mysqli_real_escape_string($this->connect, $search);
            $sql = "SELECT * FROM logs WHERE device_name LIKE '%$search%' LIMIT $offset, $limit";
        } else {
            $sql = "SELECT * FROM logs LIMIT $offset, $limit";
        }
        $result = mysqli_query($this->connect, $sql);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->connect));
        }

        $logs = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = $row;
        }
        return $logs;
    }

    public function countAllLogs($search = '')
    {
        if ($search) {
            $search = mysqli_real_escape_string($this->connect, $search);
            $sql = "SELECT COUNT(*) AS total FROM logs WHERE device_name LIKE '%$search%'";
        } else {
            $sql = "SELECT COUNT(*) AS total FROM logs";
        }
        $result = mysqli_query($this->connect, $sql);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->connect));
        }

        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function toggleDeviceAction($deviceId, $newAction)
    {
        $currentAction = $this->getCurrentAction($deviceId);

        if ($currentAction === $newAction) {
            return true;
        }

        try {
            $sql = "UPDATE logs SET action = ? WHERE id = ?";
            $stmt = mysqli_prepare($this->connect, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $newAction, $deviceId);
            mysqli_stmt_execute($stmt);
            return true;
        } catch (Exception $e) {
            die("Lỗi trong khi cập nhật hành động: " . $e->getMessage());
        }
    }

    private function getCurrentAction($deviceId)
    {
        try {
            $sql = "SELECT action FROM logs WHERE id = ?";
            $stmt = mysqli_prepare($this->connect, $sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . mysqli_error($this->connect));
            }

            mysqli_stmt_bind_param($stmt, 'i', $deviceId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                throw new Exception("No rows returned.");
            }

            $row = mysqli_fetch_assoc($result);

            if (!$row) {
                throw new Exception("No rows returned.");
            }

            return $row['action'];
        } catch (Exception $e) {
            die("Lỗi trong khi lấy hành động hiện tại: " . $e->getMessage());
        }
    }
}
