<?php
session_start();

require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/Product.php");
require_once(dirname(__FILE__) . "/Client.php");
require_once(dirname(__FILE__) . "/Admin.php");
require_once(dirname(__FILE__) . "/Order.php");
require_once(dirname(__FILE__) . "/Products_Order.php");
require_once(dirname(__FILE__) . "/Category.php");
require_once(dirname(__FILE__) . "/ProductImage.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);
$conn->query('SET NAMES utf8');
$conn->query('SET CHARACTER_SET utf8_polish_ci');

Product::SetConnection($conn);
Client::SetConnection($conn);
Admin::SetConnection($conn);
Order::SetConnection($conn);
Products_Order::SetConnection($conn);
Category::SetConnection($conn);
ProductImage::SetConnection($conn);






