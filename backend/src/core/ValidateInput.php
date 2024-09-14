<?php

namespace App\core;

use App\controllers\ProductController;

// Here I include all the validation requirements for different product types
/* This is to be a STATIC class so I made all the methods static
    this class will only be called by the API class to:
        - perform validation before forwarding the data to the Product controller */

class ValidateInput
{
    private static ProductController $productController;

    public static function validateInputInit($productController)
    {
        self::$productController = $productController;
    }

    public static function validateInput($rawInput): array
    {
        $errors = [];

        //check if the raw input is empty
        if (empty($rawInput)) {
            $errors[] = "rawInput error: No input data was provided";
            return $errors;
        }

        $data = json_decode($rawInput, true);
        if ($data === null) {   //error decoding JSON
            $errors[] = "JSON error: Invalid JSON input";
            return $errors;
        }

        //fields validation
        $errors = ValidateInput::validateAll($data);
        return $errors;
    }

    /* method to merge all the errors into one error array */
    private static function validateAll($data): array
    {
        return array_merge(
            self::validateSKU($data),
            self::validateName($data),
            self::validatePrice($data),
            self::validateTypeAndAttributes($data)
        );
    }



    private static function validateTypeAndAttributes($data): array
    {

        $errors = [];
        $types = ["Book", "DVD", "Furniture"];

        // if type is empty or not a string -> error
        if (!isset($data['type']) || !is_string($data['type']) || empty(trim($data['type']))) {
            $errors[] = "type error: type is required and must be a non-empty string.";
            //else if type does not exist within the defined types of $types array
        } elseif (!in_array($data['type'], $types)) {
            $errors[] = "type error: undefined type: '" . $data['type'] . "'. defined types are (Book, DVD, Furniture)";
            //else if type is correct, validate attributes based on type
            // if attributes does not exist or is not an array -> error
        } elseif (!isset($data['attributes']) || !is_array($data['attributes'])) {
            $errors[] = "attribute error: attributes must be provided and must be an array.";
            //else: attributes array exist
        } else {
            $type = $data['type']; // get the product type
            $attributes = $data['attributes'];
            $errors = array_merge($errors, self::validateAttributes($type, $attributes));
        }

        return $errors;
    }

    private static function validateSKU($data): array
    {
        $errors = [];
        $productsList = self::$productController->getProductsList();
        // if sku was empty or not string -> error
        if (!isset($data['sku']) || !is_string($data['sku']) || empty(trim($data['sku']))) {
            $errors[] = "SKU error: SKU is required and must be a non-empty string.";
            // if sku already exists within the controller's products list -> error
        } elseif (isset($productsList[$data['sku']])) {
            $errors[] = "SKU error: SKU '" . $data['sku'] . "' already exists";
        }

        return $errors;
    }

    private static function validateName($data): array
    {
        $errors = [];
        if (!isset($data['name']) || !is_string($data['name']) || empty(trim($data['name']))) {
            $errors[] = "name error: name is required and must be a non-empty string.";
        }

        return $errors;
    }

    private static function validatePrice($data): array
    {
        $errors = [];
        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 0 || empty(trim($data['price']))) {
            $errors[] = "price error: price is required and must be a non-negative number.";
        }
        return $errors;
    }

    private static function validateAttributes($type, $attributes): array
    {
        $errors = [];
        $attributesTable = [
            'Book' => ['weight'],
            'DVD' => ['size'],
            'Furniture' => ['height', 'width', 'length']
        ];
        if (!isset($attributes[$type])) {   //check if the attribute subarray for this type exists
            $errors[] = "attribute error: Attribute subarray for '$type' type does not exist";
        } else {
            //requiredAttributes contains the subarray elements e.g 'weight' for book and 'size' for DVD
            $requiredAttributes = $attributesTable[$type];
            //loop on each element of the subarray
            foreach ($requiredAttributes as $key) {
                //if the subarray element does not exist -> error
                if (!isset($attributes[$type][$key])) {
                    $errors[] = "attribute error: attribute '$key' does not exist within the '$type' subarray.";
                    // else if subarray element is blank
                } elseif (empty(trim($attributes[$type][$key]))) {
                    $errors[] = "attribute error: attribute '$key' of '$type' subarray must exist";
                    // else if the subarray element is negative or numeric -> error
                } elseif (!is_numeric($attributes[$type][$key]) || $attributes[$type][$key] <= 0) {
                    $errors[] = "attribute error: attribute '$key' of '$type' subarray must be numeric and positive";
                }
            }
        }
        return $errors;
    }
}