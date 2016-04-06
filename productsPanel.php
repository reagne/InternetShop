<?php

require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}
require_once("./src/Header.php");
if(isset($_GET['show'])) {
    $categoryId = $_GET['show'];
    $category = Category::GetCategoryById($categoryId);

    $allProducts = Category::GetAllFromCategory($categoryId);

    $categoryName = $category->getName();

    echo("<h1>" . ucfirst($categoryName) ."</h1>");

    echo("<table <tr><td>Id</td><td>Nazwa</td><td>Cena</td><td>Opis</td><td>Dostępność</td><td>Edytuj</td><td>Dezaktywuj</td></tr>");

    foreach ($allProducts as $productToShow) {

        $productId = $productToShow->getId();

        echo("<tr>");
        echo("<td>" . $productId . "</td>");
        echo("<td>" . $productToShow->getName() . "</td>");
        echo("<td>" . $productToShow->getPrice() . "</td>");
        echo("<td>" . $productToShow->getDescription() . "</td>");
        echo("<td>" . $productToShow->getActive() . "</td>");

        echo("<td> <a href='showProduct.php?id=$productId'>Edytuj</a></td>");
        echo("<td> <a href='showProduct.php?remove=$productId'>Dezaktywuj</a></td>");
        echo("<td> <a href='showProduct.php?addImage=$productId'>Dodaj obrazek</a></td></tr>");

    }

} else {
    $allProducts = Product::GetAllProducts();

    echo("<h1>Wszystkie produkty</h1>");

    echo("<table <tr><td>Id</td><td>Nazwa</td><td>Cena</td><td>Opis</td><td>Dostępność</td><td>Edytuj</td><td>Dezaktywuj</td><td>Dodaj obrazek</td></tr>");

    foreach ($allProducts as $productToShow) {

        $productId = $productToShow->getId();

        echo("<tr>");
        echo("<td>" . $productId . "</td>");
        echo("<td>" . $productToShow->getName() . "</td>");
        echo("<td>" . $productToShow->getPrice() . "</td>");
        echo("<td>" . $productToShow->getDescription() . "</td>");
        echo("<td>" . $productToShow->getActive() . "</td>");

        echo("<td> <a href='showProduct.php?id=$productId'>Edytuj</a></td>");
        echo("<td> <a href='showProduct.php?remove=$productId'>Dezaktywuj</a></td>");
        echo("<td> <a href='showProduct.php?addImage=$productId'>Dodaj</a></td></tr>");

    }
}

require_once("./src/Footer.php");