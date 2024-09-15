# Backend Classes:

## /api

### **`API.php`**

The `API.php` class acts as the entry point for handling HTTP requests. It routes incoming API requests to the appropriate controller methods after validation, managing operations such as retrieving, adding, and deleting products. This class also handles error responses to ensure proper communication between the backend and the frontend.

## /controllers

### **`ProductController.php`**

The ProductController.php class manages the core logic for product-related actions. It handles API requests passed from API.php, including adding, retrieving, and deleting products. It works in conjunction with the `ProductFactory` and `ProductRepo` classes to abstract and manage product operations.

## / core

### **`ValidateInput.php`**

The `ValidateInput.php` class ensures the integrity of the data provided by the user. It validates the required fields for each product type, such as SKU, name, price, and any specific attributes related to books, DVDs, or furniture. If validation fails, it returns error messages to the API to inform the user of the necessary corrections.

### **ProductFactory.php**

The `ProductFactory.php` class follows the Factory design pattern and is responsible for creating instances of different product types (Book, DVD, Furniture) based on the input data. This allows for flexibility in creating objects without needing to directly instantiate product subclasses in the main logic.

### **ProductRepo.php**

The `ProductRepo.php` class handles database interactions, including creation, reading, and deletion operations for products. It abstracts the database layer, ensuring that the ProductController can easily manage products without needing to deal directly with SQL queries or database logic.

## / models

### **`Product.php`**

The `Product.php` class is the abstract base class for all products. It defines common properties like SKU, name, and price, as well as methods that are shared across all product types. Subclasses such as Book, DVD, and Furniture inherit from this class.

### **`DVD.php`**

The `DVD.php` class extends Product and includes properties specific to DVDs, such as size (capacity in MB). It inherits common functionality from the Product class and defines logic for handling DVD-specific data.

### **`Book.php`**

The `Book.php` class extends Product and adds properties specific to books, such as weight. It overrides any necessary methods from the Product class and provides validation logic and data formatting for books.

### **`Furniture.php`**

The `Furniture.php` class extends Product and defines attributes specific to furniture, such as height, width, and length. It also provides the necessary validation and data handling for furniture products, while inheriting from the Product base class.
