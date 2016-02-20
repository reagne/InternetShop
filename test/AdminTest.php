<?php

require_once("../src/Admin.php");

class AdminTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIfObject()
    {
        $admin = new Admin('ela@wp.pl', '1234');
        $this->assertInternalType('object', $admin);
    }


}