<?php

namespace App\models;

use App\core\ProductRepo;
use PDO;
use InvalidArgumentException;

class Furniture extends Product
{
    /* attributes */
    protected string $dimensions; // string : 'HxWxL'
    protected int $length;
    protected int $width;
    protected int $height;

    /* static attributes */
    protected static string $attributeTableName = 'furniture'; // database table name that holds furniture attributes
    protected static string $type = 'Furniture';


    /* methods */

    // constructor: takes an attribute array that contains a 'Furniture' key that points to an array of
    // Furniture attributes: length, width, height
    public function __construct($sku, $name, $price, array $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->setAttributes($attributes);
    }

    /* STATIC method to fetch the attributes of this product type from its respective attribute table in the database */
    public static function fetchAttributes($pdo, $sku): array
    {
        $tableName = Furniture::$attributeTableName; // name of the table that holds Furniture attributes
        $type = Furniture::$type;
        $statement = $pdo->prepare("SELECT * FROM $tableName WHERE SKU = :sku");
        $statement->execute([':sku' => $sku]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $attributes[$type]['height'] = $result['height'];
            $attributes[$type]['width'] = $result['width'];
            $attributes[$type]['length'] = $result['length'];
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
        $furnitureSql = "INSERT INTO furniture (SKU, height, width, length) VALUES (:sku, :height, :width, :length)";
        $furnitureParams = [
            ':sku' => $this->getSKU(),
            ':height' => $this->getHeight(),
            ':width' => $this->getWidth(),
            ':length' => $this->getLength()
        ];
        $productRepo->queryDB($furnitureSql, $furnitureParams);
    }


    /* private method for Furniture type only, combines the dimensions into a string  */
    private function combineDimensions(): string
    {
        /* combine the string by x [H, W ,L ] */
        $combinedString = $this->getHeight() . 'x' . $this->getWidth() . 'x' . $this->getLength();
        return $combinedString;
    }


    /* getters and setters */

    /* method that returns an assocciative array of this product type's properties, JSON format */
    public function getData(): array
    {
        $attributeStr = "Dimensions: " . $this->getAttributes();    //Dimensions: HxWxL
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
        if (isset($attributes['Furniture']) && is_array($attributes['Furniture'])) {
            $this->length = $attributes['Furniture']['length'] ?? 0;
            $this->width = $attributes['Furniture']['width'] ?? 0;
            $this->height = $attributes['Furniture']['height'] ?? 0;
        } else {
            // in case 'Furniture' key is missing or invalid
            throw new InvalidArgumentException('Invalid attributes provided for Furniture.');
        }
        $this->dimensions = $this->combineDimensions();
    }

    public function getAttributes(): string
    {
        return $this->dimensions;
    }

    public function getType(): string
    {
        return 'Furniture';
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /* echoes ot the properties  of this object */
    public function printData(): void
    {
        parent::printData();
        echo 'Dimensions: ' . $this->dimensions . '<br>';
    }
}