<?php


require_once("./src/connection.php");

if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
}

$orderId = $_GET['id'];
$order = Order::GetOrderById($orderId);

if($_SESSION['clientId'] != $order->getClientId()){
    header("Location: index.php");
} else {

}



