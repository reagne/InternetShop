<?php
session_start();

require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/Product.php");
require_once(dirname(__FILE__) . "/Client.php");
require_once(dirname(__FILE__) . "/Admin.php");
require_once(dirname(__FILE__) . "/Order.php");
require_once(dirname(__FILE__) . "/Products_Order.php");
require_once(dirname(__FILE__) . "/Category.php");


$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);

Product::SetConnection($conn);
Client::SetConnection($conn);
Admin::SetConnection($conn);
Order::SetConnection($conn);
Products_Order::SetConnection($conn);
Category::SetConnection($conn);


if (isset($_SESSION['clientId'])) {
    echo("<a href='./index.php'>Strona główna</a>" . "  ");
    echo("<a href='./clientPanel.php'>Panel użytkownika</a>" . "  ");
    echo("<a href='./basket.php'>Koszyk</a>" . "  ");
    echo("<a href='./logout.php'>Wyloguj</a> <br>");
} elseif (isset($_SESSION['adminId'])) {
    echo("<a href='./panel.php'>Panel administracyjny</a>" . "  ");
    echo("<a href='./clientsPanel.php'>Użytkownicy</a>" . " ");
    echo("<a href='./ordersPanel.php'>Zamówienia</a>" . " ");
    echo("<a href='./productsPanel.php'>Produkty</a>" . " ");
    echo("<a href='./categoriesPanel.php'>Kategorie</a>" . " ");
    echo("<a href='./logout.php'>Wyloguj</a><br>");

}





