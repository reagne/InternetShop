<?php


require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

if(isset($_GET['remove'])) {
    $categoryIdToRemove = $_GET['id'];
    $categoryToRemove = Category::GetCategoryById($categoryIdToRemove);
    if($categoryToRemove->removeCategory()) {
        header("Location: categoriesPanel.php");
    } else {
        echo("Nie udało się usunąć kategorii");
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryToAdd = $_POST['newCategory'];
    Category::CreateCategory($categoryToAdd);
    header("Location: categoriesPanel.php");
}

echo("<h1>Kategorie: </h1>");

echo("<form method='post'>
<p>
<label>
Nowa kategoria:
<input type='text' name='newCategory'>
</label>
</p>
<input type='submit' value='Dodaj'>
</form>");

$allCategories = Category::GetAllCategories();

echo("<table <tr><td>Id</td><td>Nazwa</td><td>Zobacz</td><td>Usuń</td></tr>");

foreach ($allCategories as $categoryToShow) {

    $categoryId = $categoryToShow->getId();

    echo("<tr>");
    echo("<td>" . $categoryId . "</td>");
    echo("<td>" . $categoryToShow->getName() . "</td>");
    echo("<td> <a href='productsPanel.php?show=$categoryId'>Produkty</a></td>");
    echo("<td> <a href='categoriesPanel.php?remove=$categoryId'>Usuń</a></td></tr>");

}
echo("</table>");




