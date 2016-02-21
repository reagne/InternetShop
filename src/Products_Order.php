<?php

class Products_Order
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        Products_Order::$connection = $newConnection;
    }

    static public function GetPOById($id)
    {
        $sql = "SELECT * FROM Products_Orders WHERE id = $id";
        $result = self::$connection->query($sql);

        if ($result == true) {
           if($result->num_rows == 1) {
               $row = $result->fetch_assoc();

               $details = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity']);
               var_dump($details);
               return $details;
           }
        } else {
            return false;
        }

    }

    static public function createPO($productId, $productQuantity)
    {


    }

    private $id;
    private $productId;
    private $orderId;
    private $productQuantity;
    //private $productPrice;
    //@TODO czy na pewno jest na to potrzebne w bazie danych?

    public function __construct($newId, $newProductId, $newOrderId, $newProductQuantity)
    {
        $this->id = intval($newId);
        $this->productId = intval($newProductId);
        $this->orderId = intval($newOrderId);
        $this->setProductQuantity($newProductQuantity);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = intval($productQuantity);
    }

    public function saveQuantityToDB($newQuantity)
    {
        $sql = "UPDATE Products_Orders SET product_quantity = $newQuantity WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        } else {
            return false;
        }

    }

    public function removePO()
    {
        $sql = "DELETE FROM Products_Orders WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }

    }


}