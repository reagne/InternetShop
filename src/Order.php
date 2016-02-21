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

    public function showAllOrder()
    {
        $sql = "SELECT * FROM Products_Orders WHERE Products_Orders.order_id = $this->id;";
        $result = self::$connection->query($sql);

        if ($result == true) {
            if ($result->num_rows > 0) {
                $ret = [];
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $details = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity']);
                    $ret[] = $details;
                    //var_dump($details);
                }
                return $ret;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
//zaaktualizowanie price_sum w bazie danych.
    public function updatePriceSum()
    {
        $toUp = $this->showAllOrder();
        $priceSum = 0;
        foreach ($toUp as $toAdd) {
            $product = Product::GetProductById($toAdd->getProductId());
            $productPrice = $product->getPrice();
            $quantity = $toAdd->getProductQuantity();
            $priceSumPart = $quantity * $productPrice;
            $priceSum += $priceSumPart;
        }

        $sql = "UPDATE Orders SET price_sum = $priceSum WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatusToSent()
    {
        $sql = "UPDATE Orders SET status = 3 WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatusToPaid()
    {
        $sql = "UPDATE Orders SET status = 2 WHERE id = $this->id";
        $result = self::$connection->query($sql);

        $this->updatePriceSum();

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatusToDo()
    {
        $sql = "UPDATE Orders SET status = 1 WHERE id = $this->id";
        $result = self::$connection->query($sql);

        $this->updatePriceSum();

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }

    public function removeOrder()
    {
        $sql = "DELETE FROM Orders WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }

    }


}