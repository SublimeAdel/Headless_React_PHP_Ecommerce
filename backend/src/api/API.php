<?php

namespace App\api;

use App\controllers\ProductController;
use App\core\ProductRepo;
use App\core\ValidateInput;

class API
{

    private ProductRepo $dbHandler;
    private ProductController $controller;


    public function __construct()
    {

        $this->dbHandler = new ProductRepo();
        $this->controller = new ProductController($this->dbHandler);
    }


    /* handle frontend request here */
    public function proccessRequest(string $method)
    {
        switch ($method) {
            case 'GET': // Fetch all products
                $this->getAllProducts();
                break;
            case 'POST': // add new product
                $this->addProduct();
                break;
            case 'DELETE': // mass delete selected products
                $this->massDelete();
                break;
            default:
                echo json_encode(["errors" => "unknown method"]);
                break;
        }
    }


    /* POST: */
    /* the frontend should send json data like this
        {
            "sku": "alt512",
            "name": "productname",
            "price": 5,
            "type" : "DVD",
            "attributes": {
                "DVD": {"size" : 700}
            }
        }
    */
    private function addProduct()
    {
        $rawInput = file_get_contents("php://input");
        $errors = [];   // empty array wherein we'll push errors if they arise
        ValidateInput::validateInputInit($this->controller);    // initialize the validation class
        $errors = ValidateInput::validateInput($rawInput);  // perfrom input validation
        if (!empty($errors)) {  // if there are errors:
            http_response_code(400); // response: Bad Request
            echo json_encode(["errors" => $errors]);    // echo out the errors array
            return;
        } else {
            $data = json_decode($rawInput, true);    // get input sent from Front end
            http_response_code(201);    // response is OK
            $this->controller->addProduct($data['sku'], $data['name'], $data['price'], $data['type'], $data['attributes']);
            echo json_encode(["success" => "New product was added successfully!"]);
        }
    }


    /* GET */
    /* returns productslist in JSON format */
    private function getAllProducts()
    {
        echo json_encode($this->controller->getProductsListJson());
    }



    /* DELETE */
    /*  Front end should send json array of SKUs like this where values are strings
        [
        "alt512",
        "alt513"
        ]
    */
    private function massDelete()
    {
        $deleteList = json_decode(file_get_contents("php://input"));
        $this->controller->massDelete($deleteList);
        echo json_encode(["success" => "Products Deleted Successfully!"]);
    }
}