# ProductController.php

The `ProductController` class is responsible for handling the core functionality related to product management in the backend of this application. It acts as a bridge between the product repository (`ProductRepo`) and the client API, managing products through operations like adding new products, deleting existing ones, and fetching product lists from the database.

## Key Responsibilities

- **Adding Products**: Takes user input to create and save new products in the database, using the `ProductFactory` to instantiate the appropriate product type (e.g., Book, DVD, Furniture).

- **Mass Deletion of Products**: Deletes multiple products at once by their SKU, ensuring the product list is updated in real time.

- **Fetching Product Data**: Retrieves product data from the database, creates product objects from this data, and provides the product list in JSON format for frontend consumption.

## Consistency and Uniformity

- **Factory Pattern**: The class utilizes a `ProductFactory` to instantiate product objects based on their type, ensuring a uniform approach to handling different product types without requiring conditional logic within the controller.

- **Database Separation**: The `ProductRepo` handles database interactions, maintaining a separation of concerns and making the `ProductController` more focused on application logic rather than database operations.

- **Data Refresh**: Every time a product is added or deleted, the `refreshProductList()` method ensures that the product list is up to date, maintaining consistency between the database and the application.

## Methods

### `addProduct($sku, $name, $price, $type, $attributes)`

- **Purpose**: Adds a new product to the database given validated user input.
- **Process**:
  - Uses the `ProductFactory` to create a new product object.
  - Saves the product into the database using the product's `saveIntoDB()` method.
  - Refreshes the product list to ensure all products are up to date.

### `massDelete($deleteList)`

- **Purpose**: Deletes multiple products based on the provided list of SKUs.
- **Process**:
  - Loops through the list of SKUs.
    Checks if a product with the given SKU exists.
  - Deletes the product by calling its `deleteSelf()` method.
  - Refreshes the product list after deletion.

### `getProductsListJson()`

- **Purpose**: Returns the list of all products as a JSON array.
- **Process**:
  - Loops through the current `productsList` and retrieves the product data for each item.
  - rewrites them in JSON format before returning them to the API.

### `createProductFromData($productData)`

- **Purpose**: Instantiates a single product object from the database records.
- **Process**:
  - Takes in the product's common data thats coming from the database. These will include SKU, name, price, type.
  - Fetches specific attributes for the product by calling the product's `fetchAttributes()` method
  - Uses the `ProductFactory` to create the product object with the fetched attributes.

### `refreshProductList()`

- **Purpose**: Updates the internal list of products by syncing with the database.
- **Process**:
  - Clears the `productsList`.
  - Fills `productsData` by fetching product records from the database.
  - Converts the `productsData` into product objects using the `ProductFactory` to refill `productsList`.

### `fillProductsData()`

- **Purpose**: Populates the productsData array by fetching product data from the database.

### `fillProductsList()`

- **Purpose**: Converts the data fetched from the database into product objects and stores them in `productsList`.

### `emptyProductList()`

- **Purpose**: Clears the current list of products before repopulating it.

## Dependencies

- **`ProductFactory`**: Used to instantiate the correct product type dynamically.

- **`ProductRepo`**: Responsible for interacting with the database, fetching product data, and executing queries related to product addition and deletion.
