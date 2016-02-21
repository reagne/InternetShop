<?php

class Product
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        self::$connection = $newConnection;
    }

    static public function CreateNewProduct($newName, $newPrice, $newDescription, $newCategory, $newActive) // funkcja tworząca nowy produkt
    {
        $sql = "INSERT INTO Products(name, price, decription, category, active) VALUES('$newName', '$newPrice', '$newDescription', '$newCategory', '$newActive')";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            $newProduct = new Product(self::$connection->insert_id(), $newName, $newPrice, $newDescription, $newCategory, $newActive);
            return $newProduct;
        }
        return false;
    }

    static public function GetProductById($productId)
    {
        $sql = "SELECT * FROM Products WHERE id = $productId";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $product = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['category'], $row['active']);
                return $product;
            }
        }
        return false;
    }

    static public function GetAllProducts()
    {
        $sql = "SELECT * FROM Products";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ret[] = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['category'], $row['active']);
                }
            }
            return $ret;
        }
        return false;
    }

    private $id;
    private $name;
    private $price;
    private $description;
    private $category;
    private $active;

    public function __construct($newId, $newName, $newPrice, $newDescription, $newCategory = NULL, $newActive = 1)
    {
        $this->id = $newId;
        $this->setName($newName);
        $this->setPrice($newPrice);
        $this->setDescription($newDescription);
        $this->setCategory($newCategory);
        $this->setActive($newActive);
    }

    public function getId()
    {
        return ($this->id);
    }

    public function getName()
    {
        return ($this->name);
    }

    public function getPrice()
    {
        return ($this->price);
    }

    public function getDescription()
    {
        return ($this->description);
    }

    public function getCategory()
    {
        return ($this->category);
    }

    public function getActive()
    {
        return ($this->active);
    }

    public function setName($newName)
    {
        $this->name = $newName;
    }

    public function setPrice($newPrice)
    {
        $this->price = $newPrice;
    }

    public function setDescription($newDescription)
    {
        $this->description = $newDescription;
    }

    public function setCategory($newCategory)
    {
        $this->category = $newCategory;
    }

    public function setActive($newActive)
    {
        $this->active = $newActive;
    }
    // Metoda umożliwiająca zaktualizowanie produktu Adminowi
    public function updateProductInfo($newName, $newPrice, $newDescription, $newCategory)
    {
        $sql = "UPDATE Products SET name='$newName', price='$newPrice', description='$newDescription', category='$newCategory' WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    // Z założenia nie można usunąć produktu. Można go zdeaktywować.
    public function removeProduct() {
        $sql = "UPDATE Products SET active = 0 WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    // Pobieranie wszystkich produktów z pustą kategorią. Metoda pobierająca listę produktów z konkretną kategorią jest w klasie Category
    public function getAllWithoutCategory() {
        $sql = "SELECT * FROM Products WHERE category = NULL ORDER BY id ASC";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            if ($result->num_rows > 0) {
                $ret = [];
                while ($row = $result->fetch_assoc()) {
                    $category = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['category'], $row['active']);
                    $ret[] = $category;
                }
                return $ret;
            }
        }
        return false;
    }
    // Pobieranie wszystkich obrazów dla konkretnego produktu
    public function getAllImages($productId){
        $sql = "SELECT * FROM Images WHERE product_id = $productId";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $images = new Image($row['id'], $row['product_id'], $row['path_to_file']);
                return $images;
            }
        }
        return false;
    }

}