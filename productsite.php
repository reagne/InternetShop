<?php
require_once("./src/connection.php");
//MENU KATEGORII gdy użytkownik nie jest zalogowany
if(!isset($_SESSION['clientId'])){
    $categories = Category::GetAllCategories();
    echo("KATEGORIE: <a href='showProduct.php?category=all'>wszystkie</a>  | ");
    foreach($categories as $category) {
        echo("
    <a href='showProduct.php?category={$category->getName()}'>{$category->getName()}</a> |
    ");
    }
    echo("<a href='showProduct.php?category=other'>inne</a><br>");
}
//jeśli GETem zostanie przesłane Id produktu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = Product::GetProductById($id);
    //Wyświetalnie informacji o produkcie
    if ($product->getActive()) {
        $avaible ="dostępny";
    } else {
        $avaible = "niedostępny";
    }
    echo("<h1>{$product->getName()}</h1><table>
        <p>Cena: {$product->getPrice()} zł</p>
        <p>Produkt $avaible</p>
        <p>{$product->getDescription()}</p>
        ");
    //Wyświetlanie zdjęć produktów
    $images = ProductImage::GetImagesByProductId($id);
    foreach($images as $image) {
        echo("<image src='{$image->getPath()}' /><br>");
    }
    // Możliwość dodawania do koszyka
    if(!isset($_SESSION['clientId'])){
        echo("
        <a href='index.php'>Zaloguj się</a> lub
        <a href='register.php'>zarejestruj</a>, aby móc zamówić produkt.
        ");
    } elseif($product->getActive() == 0){
        echo("Produkt niedostępny - nie można go dodawać do koszyka");
    } else {
        echo("<form action='basket.php' method=POST>
        <label>Ilość: <input type='text' name='productQuantity' value='1'></label>
        <input type='submit' value='Dodaj do koszyka'>
        </form>");
    }
} else {
    echo("Wybierz produkt z interesującej Cię kategorii");
}
