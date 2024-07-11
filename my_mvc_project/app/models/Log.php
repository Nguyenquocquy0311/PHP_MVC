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
            $sql = "UPDATE logs SET action = :newAction WHERE device_id = :deviceId";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':newAction', $newAction);
            $stmt->bindParam(':deviceId', $deviceId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Lỗi trong khi cập nhật hành động: " . $e->getMessage());
        }
    }


    private function getCurrentAction($deviceId)
    {
        try {
            $sql = "SELECT action FROM logs WHERE device_id = :deviceId";
            $stmt = $this->connect->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare statement failed.");
            }

            $stmt->bindParam(':deviceId', $deviceId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                throw new Exception("No rows returned.");
            }

            return $row['action'];
        } catch (PDOException $e) {
            die("Lỗi trong khi lấy hành động hiện tại: " . $e->getMessage());
        } catch (Exception $e) {
            die("Lỗi trong khi lấy hành động hiện tại: " . $e->getMessage());
        }
    }
}
