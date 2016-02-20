<?php

require_once("../src/Client.php");

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIfObject()
    {
        $client = new Client('Ewa', 'Borys', 'ewa@ewa.pl', '1234', '1234', 'ul. Jagienki 6 45-100 Wrocław');
        $this->assertInternalType('object', $client);
    }


}
