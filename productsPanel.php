<?php


require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}


if(isset($_GET['show'])) {

    $categoryId = $_GET['show'];
    $category = Category::GetCategoryById($categoryId);

    $allProducts = Category::GetAllFromCategory($categoryId);

    $categoryName = $category->getName();

    echo("<h1>" . ucfirst($categoryName) ."</h1>");

    echo("<table <tr><td>Id</td><td>Nazwa</td><td>Cena</td><td>Opis</td><td>Dostępność</td><td>Edytuj</td><td>Usuń</td></tr>");

    foreach ($allProducts as $productToShow) {

        $productId = $productToShow->getId();
        var_dump($productToShow);

        echo("<tr>");
        echo("<td>" . $productId . "</td>");
        echo("<td>" . $productToShow->getName() . "</td>");
        echo("<td>" . $productToShow->getPrice() . "</td>");
        echo("<td>" . $productToShow->getDescription() . "</td>");
        echo("<td>" . $productToShow->getActive() . "</td>");

        echo("<td> <a href='categoriesPanel.php?show=$categoryId'>Edytuj</a></td>");
        echo("<td> <a href='categoriesPanel.php?id=$categoryId'>Usuń</a></td></tr>");

    }

}