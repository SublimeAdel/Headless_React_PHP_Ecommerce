# Backend Documentation

## Table of Contents

- [API Endpoints](#api)
- [Sequences](#sequences)
- [Installation](#installation)

## API Endpoints<a name = "api"></a>

| Method | Endpoint    | Description                        |
| ------ | ----------- | ---------------------------------- |
| GET    | `/main.php` | Retrieve the list of all products  |
| POST   | `/main.php` | Add a new product                  |
| DELETE | `/main.php` | Mass delete products by their SKUs |

### Sample Requests:

`Note: You could use the test requests in API_Test.http using VSCode REST client extension to test this API.`

#### **GET /main.php**

- Returns a list of all products.

- **Response Example:**

  ```json
  [
  {
      "sku": "SKU123",
      "name": "Kafka on the Shore",
      "price": 19.99,
      "type": "Book",
      "attributes": { "weight": 2.5 }
  },
  ... more products
  ]
  ```

<hr>

#### **POST /main.php**

- Add a product to the list.

- **Request Body Example:**

  ```json
  {
    "sku": "789XYZ",
    "name": "DVD",
    "price": 9.99,
    "type": "DVD",
    "attributes": { "size": 700 }
  }
  ```

- **Response Example:**

  ```json
  {
    "success": "New product was added successfully!"
  }
  ```

<hr>

#### **DELETE /main.php**

- Mass delete products from the list by their SKU.

- **Request Body Example:**

  ```json
  ["123ABC", "456DEF"]
  ```

- **Response Example:**

  ```json
  {
    "success": "Products Deleted Successfully!"
  }
  ```

## Simplified Sequence Diagrams:<a name = "sequence"></a>

### GET: Retrieving all products:

![Get sequence](https://github.com/user-attachments/assets/94423cf1-180e-4f2b-874f-1a5a09d612c7)

- #### Frontend:
  - Sends GET request.
- #### API:
  - `processRequest('GET')`
  - Calls `getAllProducts()`.
- #### ProductController:

  - Calls `getProductsListJson()`.

- #### API:
  - Sends JSON response containing all the products data.
- #### Frontend:
  - Displays product list.

<hr>

### POST: Adding a new product

![POST sequence](https://github.com/user-attachments/assets/48dff6ed-e05b-4f7a-81fe-96918c0abfd3)

- #### Frontend:

  - Sends POST request to /main.php.

- #### API:

  -` processRequest('POST')` .

  - Calls `addProduct()`.
  - Reads input data.
  - Validates input using `ValidateInput`.
    - if Valid Calls: `ProductController::addProduct()`.
    - if Invalid returns error message to the frontend

- #### ProductController:
  - Calls `ProductFactory::createProduct()` to create a product object.
  - Calls Product's method `saveIntoDB` to save the object's data into the database.
  - Refreshes product list.
- #### API:
  - Sends response back to the frontend.

<hr>

### DELETE: mass delete products:

![DELETE sequence](https://github.com/user-attachments/assets/b15ff99a-f0b4-4f49-bd8d-9e7ab7986d04)

- #### Frontend
  - Sends DELETE request with SKUs in the request body.
- #### API:
  - `processRequest('DELETE')`
  - Calls ProductController's `massDelete()` .
- #### ProductController:

  - Iterates over each product whose SKU was in the list, calling the product method `deleteSelf()` on each.

- #### API:
  - Sends success response.

<hr>

## Installation <a name = "installation"></a>

**1- Clone the repository**

**2- Set up the database**

- `you could create your own MySQL database or import the .sql file I included here.`
- change `/core/config.php` to fit your database settings

**3- Install composer**

    composer install

**4- Run the backend**

you could use `php -s` or use `XAMPP` and place the `/backend` content into `htdocs` folder

<hr>
