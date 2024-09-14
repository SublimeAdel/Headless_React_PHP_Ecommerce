<?php

namespace App\models;

use App\core\ProductRepo;
use PDO;
use InvalidArgumentException;

class DVD extends Product
{
    /* attributes */
    protected int $size; /* size in MB */

    /* static attributes */
    protected static string $attributeTableName = 'dvds'; // database table name that holds DVD attributes
    protected static string $type = 'DVD';

    /* methods */

    // constructor: takes an attribute array that contains a 'DVD' key that points to an array of DVD attributes
    public function __construct($sku, $name, $price, $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->setAttributes($attributes);
    }

    /* STATIC method to fetch the attributes of this product type from its respective attribute table in the database */
    public static function fetchAttributes($pdo, $sku): array
    {
        $tableName = DVD::$attributeTableName;   // the name of the table that holds DVD attributes
        $type = DVD::$type;
        $statement = $pdo->prepare("SELECT * FROM $tableName WHERE SKU = :sku");
        $statement->execute([':sku' => $sku]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $attributes[$type]['size'] = $result['size'];
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
        $dvdSql = "INSERT INTO dvds (SKU, size) VALUES (:sku, :size)";
        $dvdParams = [
            ':sku' => $this->getSKU(),
            ':size' => $this->getSize()
        ];
        $productRepo->queryDB($dvdSql, $dvdParams);
    }

    /* setters and getters */

    /* method that returns an assocciative array of this product type's properties */
    public function getData(): array   // returns the data in JSON format
    {
        $attributeStr = "Size: " . $this->getAttributes() . " MB";
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
        if (isset($attributes['DVD']) && is_array($attributes['DVD'])) {
            $this->size = $attributes['DVD']['size'] ?? 0;
        } else {
            // in case 'DVD' key is missing or invalid
            throw new InvalidArgumentException('Invalid attributes provided for DVD.');
        }
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getAttributes(): int
    {
        return $this->size;
    }

    public function getType(): string
    {
        return 'DVD';
    }

    public function printData(): void
    {
        parent::printData();
        echo 'Size: ' . $this->size . ' MB<br>';
    }
}