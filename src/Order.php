<?php

class Order
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        Order::$connection = $newConnection;
    }

    static public function GetOrderById($orderId)
    {
        $sql = "SELECT * FROM Orders WHERE id = $orderId";
        $result = self::$connection->query($sql);

        if ($result == true) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $order = new Order($row['id'], $row['client_id'], $row['status'], $row['price_sum']);
                return $order;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static public function GetAllOrders()
    {
        $sql = "SELECT * FROM Orders";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order = new Order($row['id'], $row['client_id'], $row['status'], $row['price_sum']);
                    $ret[] = $order;
                }
                return $ret;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private $id;
    private $clientId;
    private $status;
    private $priceSum;

    public function __construct($newId, $newClientId, $newStatus, $newPriceSum)
    {
        $this->id = intval($newId);
        $this->clientId = intval($newClientId);
        $this->setStatus($newStatus);
        $this->setPriceSum($newPriceSum);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPriceSum()
    {
        return $this->priceSum;
    }

    public function setPriceSum($priceSum)
    {
        $this->priceSum = $priceSum;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getClientId()
    {
        return $this->clientId;
    }




}