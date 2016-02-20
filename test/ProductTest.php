<?php

require_once("../src/Product.php");

class ProductTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIfObject()
    {
        $product = new Product(2, 'but', 45.78, 'super but', 2, 1);
        $this->assertInternalType('object', $product);
    }


}