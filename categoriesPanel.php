<?php


require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

if(isset($_GET['id'])) {
    $categoryIdToRemove = $_GET['id'];
    $categoryToRemove = Category::GetCategoryById($categoryIdToRemove);
    if($categoryToRemove->removeCategory()) {
        header("Location: categoriesPanel.php");
    } else {
        echo("Nie udało się usunąć kategorii");
    }

}

$allCategories = Category::GetAllCategories();

echo("<table <tr><td>Id</td><td>Nazwa</td><td>Zobacz</td><td>Usuń</td></tr>");

foreach ($allCategories as $categoryToShow) {

    $categoryId = $categoryToShow->getId();

    echo("<tr>");
    echo("<td>" . $categoryId . "</td>");
    echo("<td>" . $categoryToShow->getName() . "</td>");
    echo("<td> <a href='productsPanel.php?show=$categoryId'>Produkty</a></td>");
    echo("<td> <a href='categoriesPanel.php?id=$categoryId'>Usuń</a></td></tr>");

}
echo("</table>");

