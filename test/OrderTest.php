<?php

require_once("../src/Order.php");

class OrderTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIfObject()
    {
        $order = new Order(1, 1, 2, 45.3);
        $this->assertInternalType('object', $order);
    }


}