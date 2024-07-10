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
}
