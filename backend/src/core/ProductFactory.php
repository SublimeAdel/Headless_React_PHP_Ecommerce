<?php

namespace App\core;

use InvalidArgumentException;

/* factory class to create new products, can only be called form the ProductController class*/

class ProductFactory
{
    /* concrete classes we have so far */
    private static $productClasses = ['App\\models\\Book', 'App\\models\\DVD', 'App\\models\\Furniture'];

    public static function createProduct($sku, $name, $price, string $productType, $attributes)
    {
        $namespaceType = "App\\models\\" . $productType;    // append the namespace to the type given
        if (class_exists($namespaceType) && in_array($namespaceType, self::$productClasses)) {
            $newProduct = new $namespaceType($sku, $name, $price, $attributes); // create new product
        } else {    // if type doesnt exist
            throw new InvalidArgumentException("Invalid Product Type: $productType");
        }
        return $newProduct;
    }
}
