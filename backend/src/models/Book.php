<?php

namespace App\models;

use App\core\ProductRepo;
use PDO;
use InvalidArgumentException;

class Book extends Product
{
    /* attributes */
    protected float $weight; /*weight in KG */

    /* static attributes */
    protected static string $attributeTableName = 'books';   // database table name that holds book attributes
    protected static string $type = 'Book';

    /* methods */

    // constructor: takes an attribute array that contains a 'Book' key that points to an array of Book attributes
    public function __construct($sku, $name, $price, $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->setAttributes($attributes);
    }

    /* STATIC method to fetch the attributes of this product type from its respective attribute table in the database */
    public static function fetchAttributes($pdo, $sku): array
    {
        $tableName = Book::$attributeTableName; // name of the table that holds Book attributes
        $type = Book::$type;
        $statement = $pdo->prepare("SELECT * FROM $tableName WHERE SKU = :sku");
        $statement->execute([':sku' => $sku]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $attributes[$type]['weight'] = $result['weight'];
            return $attributes;
        } else {
            throw new InvalidArgumentException('query error.');
        }
    }

    /* method to save this object into its respective database attribute table */
    public function saveIntoDB($productRepo): void
    {
        /* save into products table using parent method */
        parent::saveIntoDB($productRepo);
        /* save into the corresponding attributes table */
        $bookSql = "INSERT INTO books (SKU, weight) VALUES (:sku, :weight)";
        $bookParams = [
            ':sku' => $this->getSKU(),
            ':weight' => $this->getWeight()
        ];
        $productRepo->queryDB($bookSql, $bookParams);
    }

    /* setters and getters */

    /* method that returns an assocciative array of this product type's properties */
    public function getData(): array
    {
        $attributeStr = "Weight: " . $this->getAttributes() . " KG";
        return [
            'sku' => $this->getSKU(),
            'name' => $this->getName(),
            'price' => round($this->getPrice(), 2),
            'type' => $this->getType(),
            'attributes' => $attributeStr
        ];
    }

    /* method to set the attributes using an associative attributes array
        The attributes array must have a key that is the product's type
        and that key points to an array of tht product's attributes */
    public function setAttributes($attributes): void
    {
        if (isset($attributes['Book']) && is_array($attributes['Book'])) {
            $this->weight = $attributes['Book']['weight'] ?? 0;
        } else {
            // in case 'Book' key is missing or invalid
            throw new InvalidArgumentException('Invalid attributes provided for Book.');
        }
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getAttributes(): float
    {
        return $this->weight;
    }

    public function getType(): string
    {
        return 'Book';
    }

    public function printData(): void
    {
        parent::printData();
        echo 'Weight: ' . $this->weight . ' KG<br>';
    }
}