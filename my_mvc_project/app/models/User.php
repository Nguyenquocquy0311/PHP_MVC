<?php

class User
{
    private $connect;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function updateUser($id, $username, $password)
    {
        $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $password, $id);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }
}
