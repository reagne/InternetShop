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

    static public function createPO($productId, $productQuantity, $productPrice)
    {


    }

    private $id;
    private $productId;
    private $orderId;
    private $productQuantity;
    private $productPrice;

    public function __construct($newId, $newProductId, $newOrderId, $newProductQuantity)
    {
        $this->id = intval($newId);
        $this->productId = intval($newProductId);
        $this->orderId = intval($newOrderId);
        $this->setProductQuantity($newProductQuantity);
        $this->setProductPrice();

    }

    public function setProductPrice()
    {
        $productId = $this->getProductId();
        $product = Product::GetProductById($productId);
        $priceForAll = $product->getPrice() * $this->productQuantity;
        $this->productPrice = $priceForAll;
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

    public function getProductPrice()
    {
        return $this->productPrice;
    }

    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;
    }




}