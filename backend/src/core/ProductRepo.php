<?php

namespace App\core;

use PDO;

class ProductRepo
{
    public $pdo;

    public function __construct($config = [])
    {
        if (empty($config)) {
            $config = require("config.php");
        }
        $host = $config['host'];
        $port = $config['port'];
        $dbname = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];
        $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", "$username", "$password");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function queryDB($sql, $params = [])
    {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    /* a function that returns a list of the products records from the Database */
    public function fetchProductsListFromDB()
    {
        $sql = 'SELECT * FROM  products ORDER BY SKU ASC';
        $statement = $this->queryDB($sql);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}