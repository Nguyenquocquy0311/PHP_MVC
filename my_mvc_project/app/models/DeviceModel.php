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

    public function addDevice($name, $macAddress, $ip, $powerConsumption)
    {
        $sql = "INSERT INTO devices (name, mac_address, ip, create_date, powerConsumption) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = mysqli_prepare($this->connect, $sql);

        if (!$stmt) {
            die("Lỗi chuẩn bị truy vấn: " . mysqli_error($this->connect));
        }

        mysqli_stmt_bind_param($stmt, 'ssss', $name, $macAddress, $ip, $powerConsumption);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            die("Lỗi khi thực thi truy vấn: " . mysqli_error($this->connect));
        }
    }

    public function deleteDevice($id)
    {
        $stmt = $this->connect->prepare("DELETE FROM devices WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateDevice($id, $name, $macAddress, $ip, $powerConsumption)
    {
        $stmt = $this->connect->prepare("UPDATE devices SET name = ?, mac_address = ?, ip = ?, powerConsumption = ? WHERE id = ?");
        $stmt->bind_param("sssdi", $name, $macAddress, $ip, $powerConsumption, $id);
        return $stmt->execute();
    }

    public function getDevicesWithPagination($start, $limit)
    {
        $stmt = $this->connect->prepare("SELECT * FROM devices LIMIT ?, ?");
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalDevices()
    {
        $result = $this->connect->query("SELECT COUNT(*) as count FROM devices");
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}
