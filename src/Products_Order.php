<?php

class Products_Order
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        Products_Order::$connection = $newConnection;
    }

    static public function getPOById($id)
    {
        $sql = "SELECT * FROM Products_Orders WHERE id = $id";
        $result = self::$connection->query($sql);

        if($result == true) {
            //@TODO: after creating constructor
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




}