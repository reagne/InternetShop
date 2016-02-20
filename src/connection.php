<?php
session_start();
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/Product.php");
require_once(dirname(__FILE__)."/Client.php");
require_once(dirname(__FILE__)."/Admin.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);

Product::SetConnection($conn);
Client::SetConnection($conn);
Admin::SetConnection($conn);



