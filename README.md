
## Table of Contents

- [About](#about)
- [Tech Stack](#tech_stack)
- [Documentation](#documentation):
  - [Backend Documentation](#backend)
  - [Frontend Documentation](#frontend)
  - [Database Documentation](#database)
- [Installation](#installation-instructions)

## About <a name = "about"></a>

This project is a web-app built as a part of a technical assessment. It features a simple product management application.

### The expected outcome of the test

A web-app containing two pages for:

1. Product list page
2. Adding a product page

### Features: <a name = "features"></a>

- View the product list on the homepage.
- Mass delete selected products.
- Add a new product.

## Tech Stack <a name = "tech_stack"></a>

- **Frontend**: React, SASS
- **Backend**: PHP ^7.4+, no frameworks, plain classes, OOP approach
- **Database**: MySQL

# Documentation<a name = "documentation"></a>:

- ## Backend:<a name= "backend"></a>

  I created a backend API that has 3 endpoints:

### API Endpoints:

- **`GET /main.php`**: Retrieves all a list of all products.
- **`POST /main.php`**: Adds a product to the product list using the product data sent in the body of the request.
- **`DELETE /main.php`**: mass deletes products by their SKUs which are provided in the body of the request.

### **Model Classes**:

- **Product**: Abstract class, serves as the base class, with shared logic for all product types.
- **Specific Product Classes**: DVD, Book, Furniture, each extend the abstract product class.

### Models UML:

  ![models_UML](https://github.com/user-attachments/assets/0ab598be-b481-4902-ae90-4e0a5dc5f613)

More details in the [Models Documentation](./backend/src/models/README.md)

### **Core Classes**:

- **ProductRepo**: interacts directly with the database using statements via PDO.
- **ProductFactory**: Factory class, instantiates products based on their type.
- **ProductController**: the main application controller, manages adding, removing, and fetching products by utilizing all the other classes.
- **ValidateInput**: Performs input validation on all user inputs.
- **API**: A single endpoint to handle user requests, through the controller.

### Core Classes UML:

  ![core_UML](https://github.com/user-attachments/assets/27d25cea-3ce0-4993-952e-58e217cd12eb)

More details in the [Backend Documentation](./backend/README.md) and [Backend Classes](./backend/src/README.md)

<hr>

- ## Frontend <a name= "frontend"></a>:

  As for the frontend I used REACT and SASS.

### Key components:

  - **Homepage**: Displays a list of products fetched from the API, with the ability to mass-delete selected products.
  - **AddProductPage**: A form for adding new products, with dynamic fields based on the selected product type.
  - **Navbar**: contains the navigation bar buttons and links as well as logo and title.
  - **Container**: a wrapper for content to provide a consistent layout.
  - **ProductList**: A grid that displays a list of products.
  - **Form**: Contains all the form inputs.
  - **Spinner**: A loading spinner during API calls.
  - **Notification**: Displays feedback to user in case of error.
  - **NavButton**: Custom button component for actions like "Mass Delete."
  - **NavLink**`: Custom link component for navigation between pages.

More details in the [Frontend Documentation](./frontend/README.md)

<hr>

- ## Database <a name = "database"></a>:

  My database is **NF3** normalized and comprises **4** tables:

### Entity Relationship Diagram:

  ![Screenshot_124](https://github.com/user-attachments/assets/a33be4a4-f72d-4b52-aaf3-afd0bc2041b5)

  - **products**:

    - SKU: (UNIQUE, VARCHAR(255), PRIMARY KEY)
    - name: (VARCHAR(255))
    - price: (FLOAT)
    - type: (VARCHAR)

  - **books**:
    - SKU: (FOREIGN KEY REFERENCES products(SKU))
    - weight: (FLOAT)
  - **dvds**:
    - SKU: (FOREIGN KEY REFERENCES products(SKU))
    - size : (INT)
  - **furniture**:
    - SKU: (FOREIGN KEY REFERENCES products(SKU))
    - height: (INT)
    - width: (INT)
    - length (INT)

  All fields have NOT NULL constraints

<hr>

## Installation instructions <a name = "installation_instructions"></a>

The instructions for installation for both frontend and backend will be included in their respective Readme.md which will be found in each of their directories.

<hr>
