<?php

require_once("./src/connection.php");

if (!isset($_SESSION['clientId']) && !isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

$clientId = $_SESSION['clientId'];

$client = Client::GetClientById($clientId);

$orderId = $_GET['id'];

$order = Order::GetOrderById($orderId);


if ($clientId == $order->getClientId()) {

    if ($order->getStatus() == 0 || $order->getStatus() == 1) {

        $order->changeStatusToDo();

        echo("<h2>Suma: {$order->getPriceSum()}</h2>");

        echo("<h3>Dane do wysyłki: </h3>");
        $clientId = $order->getClientId();
        $client = Client::GetClientById($clientId);

        echo($client->getFirstName() . " ");
        echo($client->getLastName() . "<br>");
        echo($client->getAddress());


        echo("<h3>Produkty: </h3>");
        echo("<table <tr><td>Produkt</td><td>Ilość sztuk</td><td>Cena jednostkowa:</td><td>Cena:</td></tr>");

        $everything = $order->showAllOrder();

        foreach ($everything as $details) {
            $productId = $details->getProductId();
            $product = Product::GetProductById($productId);
            $quantity = $details->getProductQuantity();

            $poId = $details->getId();

            echo("<tr>");
            echo("<td>" . $product->getName() . "</td>");
            echo("<td>" . $quantity . "</td>");
            echo("<td>" . $product->getPrice() . "</td>");
            echo("<td>" . $quantity * $product->getPrice() . "</td>");

        }
        echo("</table>");


        if (isset($_GET['removeOrder']) && $_GET['removeOrder'] == 1) {
            $order->removeOrder();
            header("Location: basket.php");
        }


        echo("<a href='orderSite.php?id=$orderId'>Zapłać</a>");


    }

}













