<?php


require_once("../src/Products_Order.php");

class Products_OrderTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIfObject()
    {
        $po = new Products_Order(1, 2, 4, 2);
        $this->assertInternalType('object', $po);
    }


}