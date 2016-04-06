<?php

class Order
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        Order::$connection = $newConnection;
    }

    static public function GetOrderById($orderId){
        $sql = "SELECT * FROM Orders WHERE id = $orderId";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $order = new Order($row['id'], $row['client_id'], $row['status']);
                return $order;
            }
        }
        return false;
    }

    static public function GetAllOrders(){
        $sql = "SELECT * FROM Orders";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order = new Order($row['id'], $row['client_id'], $row['status']);
                    $ret[] = $order;
                }
                return $ret;
            }
        }
        return false;
    }

    static public function CreateOrder($newClientId){
        $sql = "INSERT INTO Orders(client_id, status) VALUES($newClientId, 0)";
        $result = self::$connection->query($sql);
        if ($result !== FALSE) {
            $newOrder = new Order(self::$connection->insert_id, $newClientId, 0);
            return $newOrder;
        }
        return false;
    }

    private $id;
    private $clientId;
    private $status;

    public function __construct($newId, $newClientId, $newStatus){
        $this->id = intval($newId);
        $this->clientId = intval($newClientId);
        $this->setStatus($newStatus);
    }

    public function getId(){
        return $this->id;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getClientId(){
        return $this->clientId;
    }

    public function showAllOrder(){
        $sql = "SELECT * FROM Products_Orders WHERE Products_Orders.order_id = $this->id;";
        $result = self::$connection->query($sql);
        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                $ret = [];
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $details = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity']);
                    $ret[] = $details;
                    //var_dump($details);
                }
                return $ret;
            }
        }
        return false;
    }

    public function changeStatusToSent(){
        $sql = "UPDATE Orders SET status = 3 WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result !== FALSE) {
            return true;
        }
        return false;
    }

    public function changeStatusToPaid(){
        $sql = "UPDATE Orders SET status = 2 WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result == true) {
            return true;
        }
        return false;
    }

    public function changeStatusToDo(){
        $sql = "UPDATE Orders SET status = 1 WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result == true) {
            return true;
        }
        return false;
    }

    public function removeOrder(){
        $sql = "DELETE FROM Orders WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result == true) {
            return true;
        }
        return false;
    }

}