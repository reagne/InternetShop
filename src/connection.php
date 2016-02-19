<?php
session_start();
require_once(dirname(__FILE__)."./config.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);


