<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>"InternetShop - Witamy!"</title>
    <meta charset="UTF-8">
    <meta name="decription" content="Sklep WWW">
    <meta name="keywords" content="sklep">
</head>
<body>
<?php
    if (isset($_SESSION['clientId'])) {
        echo("<a href='./index.php'>Strona główna</a>" . "  ");
        echo("<a href='./clientPanel.php'>Panel użytkownika</a>" . "  ");
        echo("<a href='./basket.php'>Koszyk</a>" . "  ");
        echo("<a href='./logout.php'>Wyloguj</a> <br>");
        $categories = Category::GetAllCategories();
        echo("KATEGORIE: <a href='showProduct.php?category=all'>wszystkie</a>  | ");
        foreach($categories as $category) {
            echo("
            <a href='showProduct.php?category={$category->getName()}'>{$category->getName()}</a> |
            ");
        }
        echo("<a href='showProduct.php?category=other'>inne</a><br>");
    } elseif (isset($_SESSION['adminId'])) {
        echo("<a href='./panel.php'>Panel administracyjny</a>" . "  ");
        echo("<a href='./clientsPanel.php'>Użytkownicy</a>" . " ");
        echo("<a href='./ordersPanel.php'>Zamówienia</a>" . " ");
        echo("<a href='./productsPanel.php'>Produkty</a>" . " ");
        echo("<a href='./categoriesPanel.php'>Kategorie</a>" . " ");
        echo("<a href='./logout.php'>Wyloguj</a><br>");
    } else {
        echo("KATEGORIE: <a href='showProduct.php?category=all'>wszystkie</a>  | ");
        $categories = Category::GetAllCategories();
        foreach($categories as $category) {
            echo("
            <a href='showProduct.php?category={$category->getName()}'>{$category->getName()}</a> |
            ");
        }
        echo("<a href='showProduct.php?category=other'>inne</a><br>");
    }
?>