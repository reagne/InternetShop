<?php

require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

echo("<a href='ordersPanel.php?id=1'>Złożone</a>" . "  ");
echo("<a href='ordersPanel.php?id=2'>Zapłacone</a>" . "  ");
echo("<a href='ordersPanel.php?id=3'>Zrealizowane</a>" . "  ");


$allOrders = Order::GetAllOrders();

echo("<h1>Zamówienia ");
if ($_GET['id'] == 1) {
    echo("złożone </h1>");
} elseif ($_GET['id'] == 2) {
    echo("zapłacone </h1>");
} elseif ($_GET['id'] == 3) {
    echo("zrealizowane </h1>");
} else {
    echo("</h1>");
}


echo("<table><tr><td>Id</td><td>Id Klienta</td><td>Status</td><td>Suma</td><td>Zobacz</td></tr>");

foreach ($allOrders as $orderToSee) {
    if ($_GET['id'] == 1 && ($orderToSee->getStatus() == 1)) {
        $orderId = $orderToSee->getId();
        echo("<tr>");
        echo("<td>" . $orderId . "</td>");
        echo("<td>{$orderToSee->getClientId()}</td>");
        echo("<td>{$orderToSee->getStatus()}</td>");
        echo("<td>{$orderToSee->getPriceSum()}</td>");
        echo("<td><a href='orderSite.php?id=$orderId'>Przejdź</a></td>");


        echo("</tr>");
    }
    if ($_GET['id'] == 2 && ($orderToSee->getStatus() == 2)) {
        $orderId = $orderToSee->getId();
        echo("<tr>");
        echo("<td>" . $orderId . "</td>");
        echo("<td>{$orderToSee->getClientId()}</td>");
        echo("<td>{$orderToSee->getStatus()}</td>");
        echo("<td>{$orderToSee->getPriceSum()}</td>");
        echo("<td><a href='orderSite.php?id=$orderId'>Przejdź</a></td>");


        echo("</tr>");
    }
    if ($_GET['id'] == 3 && ($orderToSee->getStatus() == 3)) {
        $orderId = $orderToSee->getId();
        echo("<tr>");
        echo("<td>" . $orderId . "</td>");
        echo("<td>{$orderToSee->getClientId()}</td>");
        echo("<td>{$orderToSee->getStatus()}</td>");
        echo("<td>{$orderToSee->getPriceSum()}</td>");
        echo("<td><a href='orderSite.php?id=$orderId'>Przejdź</a></td>");


        echo("</tr>");
    } elseif (!isset($_GET['id'])) {
        $orderId = $orderToSee->getId();
        echo("<tr>");
        echo("<td>" . $orderId . "</td>");
        echo("<td>{$orderToSee->getClientId()}</td>");
        echo("<td>{$orderToSee->getStatus()}</td>");
        echo("<td>{$orderToSee->getPriceSum()}</td>");
        echo("<td><a href='orderSite.php?id=$orderId'>Przejdź</a></td>");


        echo("</tr>");

    }


}