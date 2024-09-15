# Models Directory

This folder contains the key models that form the foundation of the application’s backend. Each model encapsulates specific logic related to different product types and is built following (OOP) principles for consistency and uniformity.

The four models included in this directory are:

- **Product** (Abstract)
- **Book**
- **DVD**
- **Furniture**

## Overview <a name = "overview"></a>

Each product type in this application is represented by a separate class that extends a shared abstract class, `Product`. Ensuring that the common logic for all products is centralized in the parent class, while each specific product type adds its unique attributes and behaviors.

## Structure <a name = "structure"></a>

### Product.php

This abstract class serves as a blueprint for all product types. It defines the core attributes and methods that every product must implement or inherit.

Key features include:

#### Common Attributes:

- **Unique SKU**
- **Name**
- **Price**

#### Common Methods:

- **saveIntoDB()**: method for saving the product's `common attribute` in the `products` table of the database.

- **deleteSelf()**: method for removing this instance of the product from the `products` table of the database. The special attributes (e.g weight) will be removed through cascading.

#### Abstract Methods:

- **getAttributes**, **setAttributes**, **getType()**: these methods are to be implemented differently for each product type.

- `STATIC` **fetchAttributes**: an abstract static method that, depending on the type of the child, will query the correct database table that holds the specific attributes of that child type. (e.g `books` table for `Book` type)

### Book.php

The Book class extends Product and includes an additional `weight` attribute specific to books. It implements the `getAttributes()` method to return attributes unique to a book (e.g., weight in KG).

### DVD.php

The DVD class extends Product and introduces the size attribute, which stores the DVD size in MB. The getAttributes() method returns this specific attribute.

Furniture.php
The Furniture class extends Product and includes dimensions (`height`, `width`, `length`) specific to furniture. The `getAttributes()` method returns these dimensions as a string (`HxWxL`).

## Consistency and Uniformity

### Consistency

To ensure consistency, I made all the products types receive their attributes from an attributes array. This array will have a key that will be the type of the product and it will point to an array of that product's attribute.

```php
attributes = [  //for DVD
    'DVD' => [ 'size' => 251],
]
```

This was done to allow for better scalability and to avoid collision of attributes (e.g weight attribute could be later added to Furniture, which might collide with Book's weight attribute)

### Uniformity:

All models adhere to a uniform design structure by extending the abstract Product class, following these core principles:

- **DRY**: Common logic, such as managing the SKU, name, price, and persistence, is abstracted into the AbstractProduct class.

- **Single Responsibility Principle**: Each product type is responsible only for its specific attributes (e.g., weight for books, size for DVDs, dimensions for furniture).

- **Polymorphism:** Some methods (e.g `getAttributes()`) are implemented differently in each class, allowing the application to handle different product types in a consistent manner.
