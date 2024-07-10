<?php

class DeviceModel
{
    private $connect;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function getAllDevices()
    {
        $sql = "SELECT * FROM devices";
        $result = mysqli_query($this->connect, $sql);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->connect));
        }

        $devices = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $devices[] = $row;
        }
        return $devices;
    }

    public function addDevice($name, $macAddress, $ip)
    {
        $sql = "INSERT INTO devices (name, mac_address, ip, create_date, powerConsumption) VALUES (?, ?, ?, NOW(), 0)";
        $stmt = mysqli_prepare($this->connect, $sql);

        if (!$stmt) {
            die("Lỗi chuẩn bị truy vấn: " . mysqli_error($this->connect));
        }

        mysqli_stmt_bind_param($stmt, 'sss', $name, $macAddress, $ip);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }
}
