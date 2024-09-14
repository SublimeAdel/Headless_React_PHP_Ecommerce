# Frontend Documentation

## Table of Contents

- [About](#about)
- [API Integeration](#api)
- [Key Components](#comp)
- [Installation](#installation)

## About <a name = "about"></a>

### Technologies used:

- **React**
- **React Router DOM**
- **Framer Motion**
- **SASS**

I used `React` for building the UI through managable small components as well as `SASS` for styling the app.

`Framer motion` was used to add animation to product items upon spawning or deletion.

`React Router Dom` was utilized to create routes and make the frontend a SPA

## API Integeration<a name= "api"></a>

This frontend app interacts with a PHP backend through an API. The API endpoints are:

    GET /main.php: Fetches the list of products.

    POST /main.php: Adds a new product.

    DELETE /main.php: Deletes selected products.

API calls are made using fetch API:

```js
        ...
      try {
        const response = await fetch(`${BASE_URL}`, {method: "GET",});
        const products = await response.json();
        ...
```

## Page Components: <a name="pages"></a>

### **Homepage**

![Screenshot_129](https://github.com/user-attachments/assets/b35d1c52-339a-4210-be60-2d2af7bbb561)

- **Description**: The Homepage component displays a list of all products and provides functionality to delete selected products.

- **Key Features**:

  - Fetches product data from the backend API.
  - Displays the products in a grid layout.
  - Allows for mass deletion of products by selecting checkboxes.

- ### **Components**

  - **Navbar:** Displays a navigation bar with links and action buttons. In this case, it includes a link to the `Add Product page` and a "`MASS DELETE`" button for deleting multiple selected products.

  - **Mass Delete:** The "Mass Delete" button in the Navbar triggers the deletion of all selected products via a DELETE request to the API.

  - **ProductList:** A list of all products fetched from the `backend API`. Each product has a `checkbox`, and users can select products for deletion.

- ### **State Management:**

  The homepage will keep track of these states:

  - **productsList:** An array of products fetched from the API.

  - **selectedProducts:** An array of product SKUs selected for deletion.

  - **isLoading:** Boolean flag to show a spinner while loading products.

  - **error**: Error message, in case an error occurs during API requests.

- ### **Key Functions**:

  - **handleSelectedProducts:** Manages the selected products when checkboxes are toggled.

  - **handleMassDelete**: Sends a DELETE request to the API to delete the selected products.

<hr>

### AddProductPage

![Screenshot_130](https://github.com/user-attachments/assets/606bf2c7-dd5d-478c-8290-43519e9f8de0)

- **Description**: Provides a form for adding new products. The form dynamically changes based on the type of product selected (e.g., DVD, Book, Furniture).
- **Key Features**:

  - Dynamic input fields based on product type.
  - Validates input before submission.
  - Submits the new product data to the backend API.

- ### **Components:**

  - **Navbar**: Contains a "`Save`" button that triggers the form submission as well as a "`Cancel`" button that returns to the homepage.

  - **Form**: A form that allows the user to input product data such as `SKU`, `name`, `price`, `type`, and specific attributes based on the selected type.

  - **Notification**: Displays messages when there are form validation errors or API errors (e.g., SKU already exists).

- ### State Management:

  - **isLoading**: Boolean flag to show a spinner while the form is submitting.

  - **showNotification**: Boolean to control showing error notification.

  - **notification**: Stores the message for the notification (e.g., "Please, submit required data").

  - **validationErrors**: Stores error messages for individual form fields (e.g., SKU is required).

- ### Key Functions:

  - **validateForm**: Validates the form inputs before submission, ensuring that all fields are filled and contain valid data before sending them to the API.

  - **collectFormData**: Gathers the input data from the form and formats it into the appropriate object for the API.

  - **submitForm**: Sends a POST request to the API to add a new product if the form is valid.

  - **giveError**: Updates the error message for specific fields when validation fails.

## Key Components:<a name= "comp"></a>

### Navbar

- **Description**: Navigation bar that contains buttons for navigating between pages and triggering actions (like saving, cancelling, or mass deleting).
- **Key Features**:
  - Can take a Page title and a logo src as props
  - `NavButton` for actions like save or mass delete.
  - `NavLink` for navigating between the Homepage and AddProductPage.

### NavButton

- **Description**: A reusable button component used in the navbar for triggering actions like "Save" or "Mass Delete".
- **Key Features**:
  - Customizable for different actions.
  - Handles click events.

### NavLink

- **Description**: A custom navigation link for moving between the product list and add product pages.

### PageTitle

- **Description**: A component that displays the page title and an optional logo.
- **Key Features**:
  - Displays the page title.
  - Optionally renders a logo linked to the homepage.

### Container

- **Description**: A layout wrapper component that standardizes the look and feel of the pages.
- **Usage**: Used to wrap components like `ProductList` or `Form` to ensure consistent spacing and layout.

### ProductList

- **Description**: Displays a list of products in a grid format. Each product is rendered as a `ProductItem`.
- **Key Features**:
  - Listens for mass delete actions and updates the product list accordingly.
  - Uses keys like SKU for unique identification.

### ProductItem

- **Description**: Renders individual product items in the product list. Each item contains details like SKU, name, price, and attributes.
- **Key Features**:
  - Uses **Framer Motion** to animate the product items.
  - Includes a checkbox for selection, triggering mass delete actions when selected.
  - Smooth transition effects for adding or removing products from the list.

### Form

- **Description**: Contains input fields for adding new products. It adapts dynamically to the product type selected.
- **Key Features**:
  - `DynamicInput` Showing different input fields for differnet product types
  - Submits product data to the API when the user presses "Save".

### DynamicInput

- **Description**: Dynamically renders input fields based on the selected product type (DVD, Book, Furniture).
- **Key Features**:
  - Changes fields according to the selected product type from the `TypeSwitcher`.
  - Includes specific validation error messages for each input field.

### TypeSwitcher

- **Description**: A dropdown component that allows users to switch between different product types (DVD, Book, Furniture) to display relevant input fields.
- **Key Features**:
  - Provides the selected value to `DynamicInput` to render the appropriate fields.
  - Displays validation error messages if the type is not selected.

### InputField

- **Description**: A reusable input field component that is used throughout the form for various input types.
- **Key Features**:
  - Customizable for different input types (e.g., text, number).
  - Includes HTML5 input validation error handling for incorrect input.

### Spinner

- **Description**: Displays a loading spinner during API calls.
- **Usage**: Used to provide feedback to the user when waiting for data from the server.

### Notification

- **Description**: Displays error or success messages to the user.
- **Key Features**:
  - Shows success on adding/deleting products.
  - Shows errors like "SKU already exists".

## Installation <a name = "installation"></a>

**1- Clone the repository**

**2- Install dependencies**

    npm install

**3- change the `BASE_URL` in `App.jsx` to the hosted backend's `main.php`'s url**

**4 - Start the development server**

    npm run dev

**3- Install composer**

    composer install

<hr>
```
