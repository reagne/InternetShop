<?php

class Category
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        self::$connection = $newConnection;
    }

    static public function CreateCategory($newCategory)
    {
        $sql = "INSERT INTO Categories(name) VALUES('$newCategory')";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        } else {
            return false;
        }
    }

    static public function GetCategoryById($categoryId)
    {
        $sql = "SELECT * FROM Categories WHERE id = $categoryId";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $category = new Category($row['id'], $row['name']);
                return $category;
            }
        }
        return false;
    }

    static public function GetAllCategories()
    {
        $sql = "SELECT * FROM Categories ORDER BY id ASC";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            if($result->num_rows > 0) {
                $ret = [];
                while ($row = $result->fetch_assoc()) {
                    $category = new Category($row['id'], $row['name']);
                    $ret[] = $category;
                }
                return $ret;
            }
        }
        return false;
    }

    static public function GetAllFromCategory($categoryId)
    {
        $sql = "SELECT * FROM Products WHERE category = $categoryId ORDER BY id ASC";
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

    private $id;
    private $name;

    public function __construct($newId, $newName)
    {
        $this->id = $newId;
        $this->setName($newName);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function removeCategory()
    {
        $sql = "DELETE FROM Categories WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true) {
            return true;
        } else {
            return false;
        }
    }


}