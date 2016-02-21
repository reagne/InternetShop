<?php


require_once("./src/connection.php");

if (!(isset($_SESSION['adminId']))) {
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['newName'];
    $price = $_POST['newPrice'];
    $description = $_POST['newDescription'];
    $active = $_POST['newActive'];
    $category = $_POST['newCategory'];


}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = Product::GetProductById($id);

    echo("
    <form method='post'>
    <p>
    <label>
    Nazwa:
    <input type='text' name='newName' value='{$product->getName()}'>
</label>
</p>
<p>
    <label>
    Cena:
    <input type='text' name='newPrice' value='{$product->getPrice()}'>
</label>
</p>
<p>
    <label>
    Opis
    <textarea name='newDescription'>{$product->getDescription()}</textarea>>
</label>
</p>
<p>
    <label>
    Dostępność:
    <input type='text' name='newActive' value='{$product->getActive()}'>
</label>
</p>
<p>
    <label>
    Kategoria
    <input type='text' name='newCategory' value='{$product->getCategory()}'>
</label>
</p>
<input type='submit' value='Edytuj'>

    </form>

    ");


} elseif (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    var_dump($id);
    $productToRemove = Product::GetProductById($id);
    var_dump($productToRemove);
    $categoryId = $productToRemove->getCategory();
    if($productToRemove->removeProduct()) {
        header("Location: categoriesPanel.php?show=$categoryId");
    } else {
        echo("Nie udało się dezaktywować produktu");
    }

}