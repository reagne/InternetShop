<?php
require_once("./src/connection.php");
require_once("./src/Header.php");

unset($_SESSION['clientId']);
unset($_SESSION['adminId']);
$order = Order::GetOrderById($_SESSION['orderId']);
if($order->getStatus() == 0){
    $order->removeOrder();
}
unset($_SESSION['orderId']);

header("Location: index.php");

require_once("./src/Footer.php");