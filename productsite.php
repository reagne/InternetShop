<?php
require_once("./src/connection.php");
require_once("./src/Header.php");
//jeśli GETem zostanie przesłane Id produktu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = Product::GetProductById($id);

    echo("<h1>{$product->getName()}</h1>");
    //Wyświetlanie zdjęć produktów
    $images = ProductImage::GetImagesByProductId($id);
    foreach($images as $image) {
        echo("<image src='{$image->getPath()}' /><br>");
    }
    //Wyświetalnie informacji o produkcie
    if ($product->getActive()) {
        $avaible ="dostępny";
    } else {
        $avaible = "niedostępny";
    }
    echo("<table>
        <p>Cena: {$product->getPrice()} zł</p>
        <p>Produkt $avaible</p>
        <p>{$product->getDescription()}</p>
        ");
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
        <label>Ilość: <input type='text' name='productQuantity' value='1'></label><br>
        <input type='hidden' name='price' value='{$product->getPrice()}'>
        <input type='hidden' name='productId' value='$id'>
        <input type='submit' value='Dodaj do koszyka'>
        </form>");
    }
} else {
    echo("Wybierz produkt z interesującej Cię kategorii");
}
require_once("./src/Footer.php");