<?php

namespace App\controllers;

use App\core\ProductFactory;
use App\core\ProductRepo;

class ProductController
{
    private ProductRepo $ProductRepo;
    private $productsData = [];   // an array of the products Data collected from DB
    private $productsList = [];  // a List of the product objects

    public function __construct($ProductRepo)
    {
        $this->ProductRepo = $ProductRepo;
        $this->refreshProductList();
    }


    /* private method to refresh the productList array. */
    private function refreshProductList()
    {
        $this->emptyProductList();  //empty list
        $this->fillProductsData();  //fill list with database records
        $this->fillProductsList();  //fill list with initialized objects based on records
    }


    /* add product functionality: takes the properties of the new product to be added from the user
        calls the factory class and passes to it these values, saves it into the database
        then refreshes the product list so that its up to date
        this method will only be called if the input data is valid */
    public function addProduct($sku, $name, $price, $type, $attributes)
    {
        $newProduct = ProductFactory::createProduct($sku, $name, $price, $type, $attributes);   //create the product
        $newProduct->saveIntoDB($this->getProductRepo());     // save it into database
        $this->refreshProductList();    //refresh productList and productData from database
    }

    /* mass delete functionality: given a list of products' SKUs, it will go through them one by one
        checking if a product of such SKU exists and then calling the deleteSelf method on it.
        afterwards it will refresh the product list. this method will only be called if the deleteList is not empty */
    public function massDelete($deleteList)
    {
        /* deleteList is a list of the SKUs to be deleted from the database */
        $productsList = $this->getProductsList();
        foreach ($deleteList as $sku) {
            if (isset($productsList[$sku])) {    //pass the database from which it will remove itself
                $productsList[$sku]->deleteSelf($this->getProductRepo());
            }
        }
        $this->refreshProductList();    /* refresh the product list */
    }

    /* fills up productsData array with the data returned from the database */
    private function fillProductsData()
    {
        $this->productsData = $this->ProductRepo->fetchProductsListFromDB();
    }

    /* populates the productsList array with objects instantiated from the data aquired from the database*/
    private function fillProductsList()
    {
        $productsData = $this->getProductsData();
        foreach ($this->productsData as $key => $value) {
            /* function to create a single product given an array of its attributes */
            $newProduct = $this->createProductFromData($productsData[$key]);
            $this->productsList[$newProduct->getSKU()] = $newProduct;          /* append the new product */
        }
    }

    /* function to create a single product given an associative array of its common attributes
        it will be called to instantiate product objects from the database after fetching
        productData is an associative array having keys such as SKU, name, price, type */
    private function createProductFromData($productData)
    {
        $pdo = $this->ProductRepo->getPDO();
        $sku = $productData['SKU'];
        $name = $productData['name'];
        $price = $productData['price'];
        $type = $productData['type'];
        $namespaceType = "App\\models\\$type";
        // fetch the specific attribute for this type from its attribute table in the database
        $attributes = $namespaceType::fetchAttributes($pdo, $sku);
        // call onto the factory class to create a new product object
        $newProduct = ProductFactory::createProduct($sku, $name, $price, $type, $attributes);
        return $newProduct;
    }


    private function emptyProductList()
    {
        $this->productsList = [];
    }

    /* getters */

    // returns the productsList array in JSON format
    public function getProductsListJson()
    {
        $productsListJson = [];
        foreach ($this->getProductsList() as $product) {
            $productsListJson[] = $product->getData();
        }
        return $productsListJson;
    }

    private function getProductRepo()
    {
        return $this->ProductRepo;
    }

    public function getProductsData()
    {
        return $this->productsData;
    }

    public function getProductsList()
    {
        return $this->productsList;
    }
}
