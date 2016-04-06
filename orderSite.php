<?php

require_once("./src/connection.php");
require_once("./src/Header.php");

$orderId = $_SESSION['orderId'];
$order = Order::GetOrderById($orderId);

if ($_SESSION['clientId'] != $order->getClientId() && !isset($_SESSION['clientId']) && !(isset($_SESSION['adminId']))) {
    header("Location: index.php");
} else {
    $status = $order->getStatus();
    //var_dump($status);

    if ($status != 0) {
        echo("<h2>Szczegóły</h2>");
        $price = Products_Order::GetSumPriceByOrderId($orderId);
        echo("<h3>Suma: $price</h3>");
        echo("<h4>Status zamówienia: ");
        if ($status == 1) {
            echo("Złożone. Oczekuje na zapłatę. <br>");
            if (isset($_SESSION['clientId'])) {
                echo("<a href='orderSite.php?id=$orderId&status=2'>Zapłać</a>");
            }
        } elseif ($status == 2) {
            echo("Zapłacone. Oczekuje na wysyłkę");
        } elseif ($status == 3) {
            echo("Zrealizowane");
        }

        $everything = $order->showAllOrder();
        echo("<table border='1px' <th><td>Produkt</td><td>Ilość sztuk</td><td>Cena jednostkowa:</td><td>Cena:</td></th>");

        foreach ($everything as $details) {
            $productId = $details->getProductId();
            $product = Product::GetProductById($productId);
            $quantity = $details->getProductQuantity();
            echo("<tr>");
            echo("<td>" . $product->getName() . "</td>");
            echo("<td>" . $quantity . "</td>");
            echo("<td>" . $product->getPrice() . "</td>");
            echo("<td>" . $quantity * $product->getPrice() . "</td></tr>");
        }
        echo("</table>");

        if (isset($_SESSION['adminId'])) {
            if ($status == 2) {
                echo("Wyślij zamówienie: ");
                echo("<a href='orderSite.php?id=$orderId&status=3'>Zmień status na wysłane</a>");
            }
        }

        if (isset($_GET['status']) && $_GET['status'] == 3) {
            if ($order->changeStatusToSent()) {
                header("Location: orderSite.php?id=$orderId");
            } else {
                echo("Nie udało się zmienić statusu");
            }
        }

        if (isset($_GET['status']) && $_GET['status'] == 2) {
            if ($order->changeStatusToPaid()) {
                header("Location: orderSite.php?id=$orderId");
            } else {
                echo("Nie udało się zmienić statusu");
            }
        }
    }
}
require_once("./src/Footer.php");



