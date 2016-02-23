<?php
class ProductImage
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        self::$connection = $newConnection;
    }
    // Dodawanie obrazka do produktu
    static public function AddNewImage($product_id, $filePath)
    {
        $sql = "INSERT INTO Images(product_id, path_to_file) VALUES($product_id, '$filePath')";
        $result = self::$connection->query($sql);

        if ($result != FALSE) {
            return true;
        }
        return false;
    }

    static public function GetImageById($imageId)
    {
        $sql = "SELECT * FROM Images WHERE id = $imageId";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $image = new ProductImage($row['id'], $row['product_id'], $row['path_to_file']);
                return $image;
            }
        }
        return false;
    }

    private $id;
    private $product_id;
    private $path;

    public function __construct($newId, $newProduct_id, $newPath)
    {
        $this->id = $newId;
        $this->product_id = $newProduct_id;
        $this->setPath($newPath);
    }

    public function getId()
    {
        return ($this->id);
    }

    public function getProduct_id()
    {
        return ($this->product_id);
    }

    public function getPath()
    {
        return ($this->path);
    }

    public function setPath($newPath)
    {
        $this->path = $newPath;
    }



}