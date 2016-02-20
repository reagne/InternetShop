<?php


require_once("./src/connection.php");

if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
}

$orderId = $_GET['id'];
$order = Order::GetOrderById($orderId);

if ($_SESSION['clientId'] != $order->getClientId()) {
    header("Location: index.php");
} else {

    $status = $order->getStatus();

    if ($status != 0) {

        echo("<h2>Szczegóły</h2>");
        echo("<h3>Suma: {$order->getPriceSum()}</h3>");
        echo("<h4>Status zamówienia: ");
        if ($status == 1) {
            echo("Złożone. Oczekuje na zapłatę. <br>");
            echo("<a href='#'>Zapłać</a>"); //@TODO link zmieniający 1 na 2.
        } elseif ($status == 2) {
            echo("Zapłacone. Oczekuje na wysyłkę");
        } elseif ($status == 3) {
            echo("Zrealizowane");
        }
        echo("<h4>");


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

    }


}



