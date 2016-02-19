<?php
class Product {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        self::$connection = $newConnection;
    }
    static public function CreateNewProduct ($newName, $newPrice, $newDescription, $newCategory, $newActive){

    }

    private $id;
    private $name;
    private $price;
    private $description;
    private $category;
    private $active;

    public function __construct($newId, $newName, $newPrice, $newDescription, $newCategory=NULL, $newActive=1)
    {
        $this->id = $newId;
        $this->setName($newName);
        $this->setPrice($newPrice);
        $this->setDescription($newDescription);
        $this->setCategory($newCategory);
        $this->setActive($newActive);
    }
    public function getId(){
        return ($this->id);
    }
    public function getName(){
        return ($this->name);
    }
    public function getPrice(){
        return ($this->price);
    }
    public function getDescription(){
        return ($this->description);
    }
    public function getCategory(){
        return ($this->category);
    }
    public function getActive(){
        return ($this->active);
    }
    public function setName($newName){
        $this->name = $newName;
    }
    public function setPrice($newPrice){
        $this->price = $newPrice;
    }
    public function setDescription($newDescription){
        $this->description = $newDescription;
    }
    public function setCategory($newCategory){
        $this->category = $newCategory;
    }
    public function setActive($newActive){
        $this->active = $newActive;
    }
    public function updateProductInfo ($newName, $newPrice, $newDescription){

    }
    public function changeProductCategory ($newCategory){

    }
    public function changeProductActive ($newActive) {

    }

}