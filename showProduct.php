<?php

require_once("./src/connection.php");

if (isset($_SESSION['adminId'])) {
    if (!(isset($_GET['addImage']))) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id']);
            $name = $_POST['newName'];
            $price = $_POST['newPrice'];
            $description = $_POST['newDescription'];
            $active = intval($_POST['newActive']);
            $category = intval(['newCategory']);

            $product = Product::GetProductById($id);

            if ($product->updateProductInfo($name, $price, $description, $category, $active)) {
                header("Location: productsPanel.php?show=$category");
            } else {
                echo("Nie udało się edytować produktu.");
            }
        }

        /*
        $id = $_GET['id'];
        $product = Product::GetProductById($id);

        echo("
        <form action='showProduct.php' method='post'>
        <p>
        <label>Id (nie podlega edycji)
        <input type='text' name='id' value='{$product->getId()}'</label>
    </p>
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
    </form>");
    */
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = Product::GetProductById($id);

        echo("
        <form method='post'>
        <p><label>Id (nie podlega edycji)<input type='text' name='id' value='{$product->getId()}'</label></p>
        <p><label>Nazwa: <input type='text' name='newName' value='{$product->getName()}'></label></p>
        <p><label>Cena: <input type='text' name='newPrice' value='{$product->getPrice()}'></label></p>
        <p><label>Opis: <textarea name='newDescription'>{$product->getDescription()}</textarea>></label></p>
        <p><label>Dostępność:<input type='text' name='newActive' value='{$product->getActive()}'></label></p>
        <p><label>Kategoria: <input type='text' name='newCategory' value='{$product->getCategory()}'></label></p>
        <input type='submit' value='Edytuj'>
        </form>
        ");
    } elseif (isset($_GET['remove'])) {
        $id = intval($_GET['remove']);
        var_dump($id);
        $productToRemove = Product::GetProductById($id);
        var_dump($productToRemove);
        $categoryId = $productToRemove->getCategory();
        if ($productToRemove->removeProduct()) {
            header("Location: categoriesPanel.php?show={$categoryId}");
        } else {
            echo("Nie udało się dezaktywować produktu");
        }
    } elseif (isset($_GET['addImage'])) {
        $product_id = intval($_GET['addImage']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filesName = $_FILES['upload']['name'];
            $uploaddir = dirname(__FILE__);
            $uploadfile = $uploaddir. '/src/images/' . basename($_FILES['upload']['name']);
            if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)){

                echo "File is valid, and was successfully uploaded.\n";

            } else {

                echo "Possible file upload attack!\n";
            }
            var_dump($uploadfile);

            $newImage = ProductImage::AddNewImage($product_id, $uploadfile);
        }
        echo("
        <form method='post' enctype='multipart/form-data'>
            <p><label>Dodaj obraz: <input type='file' name='upload'></label></p>
            <input type='submit' value='Dodaj obrazek'>
        </form>
        ");
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $category = $_GET['category'];
        echo("<table><tr><td>Nazwa</td><td>Cena</td><td>Dostępność</td><td>Opis</td><td>Zobacz</td></tr>");
        if ($category == "all") {
            echo("<h1>Wszystkie produkty</h1>");
            $products = Product::GetAllProducts();
            foreach ($products as $product) {
                if ($product->getActive() == 1) {
                    $avaible = "Tak";
                } else {
                    $avaible = "Nie";
                }
                echo("<tr>
                <td>{$product->getName()}</td><td>{$product->getPrice()} </td><td>$avaible </td><td>{$product->getDescription()}</td> <td><a href='productsite.php?id={$product->getId()}'>Zobacz</a></td> </tr>
                ");
            }
        } elseif ($category == "other") {
            $products = Product::getAllWithoutCategory();
            echo("<h1>Inne</h1>");
            foreach ($products as $product) {
                if ($product->getActive() == 1) {
                    $avaible = "Tak";
                } else {
                    $avaible = "Nie";
                }
                echo("
                <tr>
                <td>{$product->getName()}</td><td>{$product->getPrice()} </td><td>$avaible </td><td>{$product->getDescription()}</td> <td><a href='productsite.php?id={$product->getId()}'>Zobacz</a></td> </tr>
                ");
            }
        } else {
            $categories = Category::GetAllCategories();
            foreach ($categories as $cat) {
                if ($category == $cat->getName()) {
                    echo("<h1>" . ucfirst($cat->getName()) . "</h1>");
                    $products = Category::GetAllFromCategory($cat->getId());
                    foreach ($products as $product) {
                        if ($product->getActive() == 1) {
                            $avaible = "Tak";
                        } else {
                            $avaible = "Nie";
                        }
                        echo("
                        <tr>
                <td>{$product->getName()}</td><td>{$product->getPrice()} </td><td>$avaible </td><td>{$product->getDescription()}</td> <td><a href='productsite.php?id={$product->getId()}'>Zobacz</a></td> </tr>
                        ");
                    }
                }
            }
        }
        echo("</table>");
    }
}


