<?php

require_once("./src/connection.php");

if (!isset($_SESSION['clientId']) && !isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

$clientId = $_SESSION['clientId'];

$client = Client::GetClientById($clientId);

$allBasket = $client->getBasket();


echo("<h2>Koszyk</h2>");
if ($allBasket == false) {
    echo("<h3>Suma: 0</h3>");

}


if ($allBasket != false)

    $orderId = $allBasket[0]->getOrderId();
$order = Order::GetOrderById($orderId);
echo("<h3>Suma: {$order->getPriceSum()}</h3>");


echo("<table <tr><td>Produkt</td><td>Mniej</td><td>Ilość sztuk</td><td>Więcej</td><td>Cena jednostkowa:</td><td>Cena:</td><td>Usuń</td></tr>");


foreach ($allBasket as $details) {
    $productId = $details->getProductId();
    $product = Product::GetProductById($productId);
    $quantity = $details->getProductQuantity();

    $poId = $details->getId();

    echo("<tr>");
    echo("<td>" . $product->getName() . "</td>");
    echo("<td> <a href='basket.php?minus=1&id=$poId'>-</a></td>");
    echo("<td>" . $quantity . "</td>");
    echo("<td> <a href='basket.php?plus=1&id=$poId'>+</a> </td>");
    echo("<td>" . $product->getPrice() . "</td>");
    echo("<td>" . $quantity * $product->getPrice() . "</td>");
    echo("<td> <a href='basket.php?rem=1&id=$poId'>Usuń</a> </td></tr>");


}
echo("</table>");

if (isset($_GET['id'])) {
    $poId = $_GET['id'];
    $po = Products_Order::GetPOById($poId);

    $quantity = $po->getProductQuantity();
    if ($_GET['minus'] == 1) {
        if ($quantity >= 2) {
            $quantity -= 1;
            $po->saveQuantityToDB($quantity);
            header("Location: basket.php");
        }
    } elseif ($_GET['plus'] == 1) {
        if ($quantity >= 1) {
            $quantity += 1;
            $po->saveQuantityToDB($quantity);
            header("Location: basket.php");
        }
    } elseif ($_GET['rem'] == 1) {
        if ($po->removePO()) {
            header("Location: basket.php");
        }

    }

}

if (isset($_GET['removeOrder']) && $_GET['removeOrder'] == 1) {
    $order->removeOrder();
    header("Location: basket.php");
}

echo("<a href='basket.php?removeOrder=1'>Wyczyść koszyk</a><br>");
echo("<a href='basket2.php?id=$orderId'>Złóż zamówienie</a>");





