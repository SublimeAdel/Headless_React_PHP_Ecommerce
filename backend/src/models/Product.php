<?php

namespace App\models;

use App\core\ProductRepo;

abstract class Product
{
    /* common attributes to be inherited */
    protected string $SKU;
    protected string $name;
    protected float $price;


    public function __construct($sku, $name, $price)
    {
        $this->SKU = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    /* methods */

    /* to be overridden by the child
        saves the common attributes of each product at the products table of the database */
    public function saveIntoDB(ProductRepo $productRepo)
    {
        $sql = "INSERT INTO products (SKU, name, price, type) VALUES (:sku, :name, :price, :type)";
        $params = [
            ':sku' => $this->getSKU(),
            ':name' => $this->getName(),
            ':price' => $this->getPrice(),
            ':type' => $this->getType()
        ];
        $productRepo->queryDB($sql, $params);
    }

    /* method to remove self from the Products table of the database
        the deletion will cascade to the special attributes table of each product */
    public function deleteSelf(ProductRepo $productRepo): void
    {
        $sql = "DELETE FROM products WHERE SKU = :sku";
        $params = [
            ':sku' => $this->getSKU()
        ];
        $productRepo->queryDB($sql, $params);
    }


    /* Abstract methods */

    /* these change according to the type  */
    abstract public function getType();
    abstract public function getAttributes();
    abstract public function setAttributes(array $attributes);

    /* Static methods */

    /* depending on the type of the child, this static function handles fetching the special attributes
    it queries the correct table and searches for the SKU entry */
    abstract public static function fetchAttributes($pdo, $sku);


    /* getters */
    public function getSKU(): string
    {
        return $this->SKU;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }


    /* Setters */
    public function setSKU($sku): void
    {
        $this->SKU = $sku;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function printData(): void
    {
        echo $this->SKU . '<br>';
        echo $this->name . '<br>';
        echo round($this->price, 2) . ' $<br>';
    }
}