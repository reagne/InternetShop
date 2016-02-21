<?php


class Client
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        Client::$connection = $newConnection;
    }

    static public function RegisterClient($newFirstName, $newLastName, $newEmail, $password1, $password2, $newAddress)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Clients(first_name, last_name, email, password, address) VALUES ('$newFirstName', '$newLastName', '$newEmail', '$hashedPassword', '$newAddress')";

        $result = self::$connection->query($sql);
        if ($result == TRUE) {
            $newClient = new Client(self::$connection->insert_id, $newFirstName, $newLastName, $newEmail, $newAddress);
            return $newClient;
        }
        return false;
    }

    static public function LogInClient($email, $password)
    {
        $sql = "SELECT * FROM Clients WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK === TRUE) {
                    $client = new Client($row['id'], $row['firstName'], $row['lastName'], $row['email'], $row['address']);
                    return $client;
                }
            }
        }
        return false;
    }

    static public function GetClientById($idToLoad)
    {
        $sql = "SELECT * FROM Clients where id = $idToLoad";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $client = new Client($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['address']);
                return $client;

            }
        }
        return false;
    }

    static public function GetAllClients()
    {
        $ret = [];
        $sql = "SELECT * FROM Clients";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $client = new Client($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['address']);
                    $ret[] = $client;
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setAddress($newAddress)
    {
        if (strlen($newAddress) > 0) {
            $this->address = $newAddress;
        } else {
            return false;
        }
    }

    public function changeAddress($newAddress)
    {
        $this->setAddress($newAddress);

        $sql = "UPDATE Clients SET address = '$this->address' WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function changeEmail($newEmail)
    {
        $this->setEmail($newEmail);

        $sql = "UPDATE Clients SET email = '$this->email' WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function changeFirstName($newFirstName)
    {
        $this->setFirstName($newFirstName);

        $sql = "UPDATE Clients SET first_name = '$this->firstName' WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function changeLastName($newLastName)
    {
        $this->setLastName($newLastName);
        $sql = "UPDATE Clients SET last_name = '$this->lastName' WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($oldPassword, $newPassword1, $newPassword2)
    {
        $sql = "SELECT * FROM Clients WHERE id=$this->id";
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

                    $sql2 = "UPDATE Clients SET password='$hashedPassword' WHERE id=$this->id";
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

    public function removeClient()
    {
        $sql = "DELETE FROM Clients WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }

    }

    public function createOrder()
    {
        $sql = "INSERT INTO Orders(client_id, status, price_sum) VALUES($this->id, 0, 0)";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $newOrder = new Order(self::$connection->insert_id, $this->id, 0, 0);
            return $newOrder;
        } else {
            return false;
        }
    }

    public function getAllMyOrders()
    {
        $sql = "SELECT * FROM Orders WHERE client_id = $this->id ORDER BY id DESC";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order = new Order($row['id'], $row['client_id'], $row['status'], $row['price_sum']);
                    $ret[] = $order;
                }
            }
            return $ret;
        } else {
            return false;
        }
    }

    public function getBasket()
    {
        $sql = "SELECT Products_Orders.id, Products_Orders.product_id, Products_Orders.order_id, Products_Orders.product_quantity, Products_Orders.product_price  FROM Products_Orders JOIN Orders ON Products_Orders.order_id = Orders.id WHERE Orders.client_id = $this->id AND Orders.status = 0 ORDER BY Products_Orders.id DESC";
        $result = self::$connection->query($sql);

        if($result == true) {
            $ret = [];
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $po = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity']);
                    $ret[] = $po;
                }
            }

            return $ret;
        } else {
            return false;
        }
    }

}


?>