<?php


require_once("./src/connection.php");

if(!isset($_SESSION['clientId'])){
    header("Location: index.php");
}

$clientId = $_SESSION['clientId'];

$client = Client::GetClientById($clientId);

var_dump($client);