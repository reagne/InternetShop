<?php

/*
 CREATE TABLE Users(
    id int AUTO_INCREMENT,
    name varchar(255),
    email varchar(255) UNIQUE,
    password char(60),
    description varchar(255),
    PRIMARY KEY (id)
);
 */

class User
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        User::$connection = $newConnection;
    }

    static public function RegisterUser($newFirstName, $newLastName, $newEmail, $password1, $password2, $newAddress)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Users(firstname, lastname, email, password, address) VALUES ('$newFirstName', '$newLastName', '$newEmail', '$hashedPassword', '$newAddress')";

        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            $newUser = new User(self::$connection->insert_id, $newFirstName, $newLastName, $newEmail, $newAddress);
            return $newUser;
        }
        return false;
    }

    static public function LogInUser($email, $password)
    {
        $sql = "SELECT * FROM Users WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK === TRUE) {
                    $user = new User($row['id'], $row['firstName'], $row['lastName'], $row['email'], $row['address']);
                    return $user;
                }
            }
        }
        return false;
    }

    static public function GetUserById($idToLoad)
    {
        $sql = "SELECT * FROM Users where id = $idToLoad";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $user = new User($row['id'], $row['firstName'], $row['lastName'], $row['email'], $row['address']);
                return $user;

            }
        }
        return false;
    }

    static public function GetAllUsers()
    {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $user = new User($row['id'], $row['firstName'], $row['lastName'], $row['email'], $row['address']);
                    $ret[] = $user;
                }
            }
        }
        return $ret;
    }


    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $address;

    public function __construct($newId, $newFirstName, $newLastName, $newEmail, $newAddress)
    {
        $this->id = intval($newId);
        $this->firstName = $newFirstName;
        $this->lastName = $newLastName;
        $this->email = $newEmail;
        $this->setAddress($newAddress);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($newAddress)
    {
        if (strlen($newAddress) > 0) {
            return ($this->address = $newAddress);
        } else {
            return false;
        }
    }

    public function changePassword($oldPassword, $newPassword1, $newPassword2)
    {

        $sql = "SELECT * FROM Users WHERE id=$this->id";
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

                    $sql2 = "UPDATE Users SET password='$hashedPassword' WHERE id=$this->id";
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