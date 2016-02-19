<?php
session_start();
require_once(dirname(__FILE__)."./config.php");
require_once(dirname(__FILE__)."./Product.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);

Product::SetConnection($conn);
