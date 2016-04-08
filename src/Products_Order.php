<?php

class Products_Order
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        Products_Order::$connection = $newConnection;
    }
    static public function GetPOById($id){
        $sql = "SELECT * FROM Products_Orders WHERE id = $id";
        $result = self::$connection->query($sql);
        if ($result == true) {
           if($result->num_rows == 1) {
               $row = $result->fetch_assoc();
               $details = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity'], $row['product_price']);
               var_dump($details);
               return $details;
           }
        } else {
            return false;
        }
    }
    static public function CreatePO($newProductId, $newOrderId, $newProductQuantity, $newProductPrice){
        $sql = "INSERT INTO Products_Orders(product_id, order_id, product_quantity, product_price) VALUES ($newProductId, $newOrderId, $newProductQuantity, $newProductPrice)";
        $result = self::$connection->query($sql);
        if ($result !== FALSE) {
            $newPO = new Products_Order(self::$connection->insert_id, $newProductId, $newOrderId, $newProductQuantity, $newProductPrice);
            return $newPO;
        }
        return false;
    }
    static public function GetSumPriceByOrderId($orderId){
        $sumPrice = 0;
        $sql = "SELECT product_quantity, product_price FROM Products_Orders WHERE order_id = $orderId";
        $result = self::$connection->query($sql);
        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $sumPrice = $sumPrice + ($row['product_quantity'] * $row['product_price']);
                }
                return $sumPrice;
            }
        }
        return false;
    }
    static public function GetProductsByOrderId($orderId){
        $sql = "SELECT product_id FROM Products_Orders WHERE order_id = $orderId";
        $result = self::$connection->query($sql);
        if($result !== FALSE){
            $ret = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $ret[] = $row['product_id'];
                }
                return $ret;
            }
        }
        return false;
    }
    static public function GetPOByProductId($productId){
        $sql = "SELECT * FROM Products_Orders WHERE product_id = $productId";
        $result = self::$connection->query($sql);
        if($result !== FALSE){
            if($result->num_rows == 1){
                $row = $result->fetch_assoc();
                $ret = new Products_Order($row['id'], $row['product_id'], $row['order_id'], $row['product_quantity'], $row['product_price']);
            }
            return $ret;
        }
        return false;
    }

    private $id;
    private $productId;
    private $orderId;
    private $productQuantity;
    private $productPrice;

    public function __construct($newId, $newProductId, $newOrderId, $newProductQuantity, $newProductPrice)
    {
        $this->id = intval($newId);
        $this->productId = intval($newProductId);
        $this->orderId = intval($newOrderId);
        $this->setProductQuantity($newProductQuantity);
        $this->setProductPrice($newProductPrice);   // dajemy tutaj productPrice, gdyż cena produktu może się zmienić później
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

    public function getProductPrice()
    {
        return $this->productPrice;
    }

    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = intval($productQuantity);
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = floatval($productPrice);
    }

    public function saveQuantityToDB($newQuantity)
    {
        $sql = "UPDATE Products_Orders SET product_quantity = $newQuantity WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            return true;
        }
        return false;
    }

    public function removePO()
    {
        $sql = "DELETE FROM Products_Orders WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            return true;
        }
        return false;
    }

}