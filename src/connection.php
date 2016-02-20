<?php
session_start();
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/Product.php");
require_once(dirname(__FILE__)."/User.php");
require_once(dirname(__FILE__)."/Admin.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);

Product::SetConnection($conn);
User::SetConnection($conn);
Admin::SetConnection($conn);



