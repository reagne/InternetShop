<?php

class Admin
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        Admin::$connection = $newConnection;
    }

    static public function RegisterAdmin($newEmail, $password1, $password2)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Admins(email, password) VALUES ('$newEmail', '$hashedPassword')";

        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            $newAdmin = new Admin(self::$connection->insert_id, $newEmail);
            return $newAdmin;
        }
        return false;
    }

    static public function LogInAdmin($email, $password)
    {
        $sql = "SELECT * FROM Admins WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK === TRUE) {
                    $admin = new Admin($row['id'], $row['email']);
                    return $admin;
                }
            }
        }
        return false;
    }

    private $id;
    private $email;


    public function __construct($newId, $newEmail)
    {
        $this->id = intval($newId);
        $this->email = $newEmail;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function changePassword($oldPassword, $newPassword1, $newPassword2)
    {
        $sql = "SELECT * FROM Admins WHERE id=$this->id";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($oldPassword, $row['password']);

                if ($isPasswordOK === TRUE) {

                    if ($newPassword1 !== $newPassword2) {
                        return false;
                    }

                    $options = [
                        'cost' => 11,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
                    ];

                    $hashedPassword = password_hash($newPassword1, PASSWORD_BCRYPT, $options);

                    $sql2 = "UPDATE Admins SET password='$hashedPassword' WHERE id=$this->id";
                    $result = self::$connection->query($sql2);

                    if ($result == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
                return false;
            }
        } else {
            return false;
        }
        return false;
    }




}


?>