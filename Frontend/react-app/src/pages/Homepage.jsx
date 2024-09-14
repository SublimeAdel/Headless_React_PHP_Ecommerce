import React from "react";
import Navbar from "../components/Navbar";
import Container from "../components/Container";
import ProductList from "../components/ProductList";
import NavButton from "../components/NavButton";
import NavLink from "../components/NavLink";
import { useState, useEffect } from "react";

const Homepage = ({ baseURL }) => {
  const BASE_URL = baseURL;
  // states:

  const [productsList, setProductsList] = useState([]); //keeps track of the product list
  const [selectedProducts, setSelectedProducts] = useState([]); //keeps track of selected products
  const [isLoading, setIsLoading] = useState(false); // keeps track of loading to show spinner
  const [error, setError] = useState();

  // effects:

  // fetch the products from the API
  // will run  once homepage is mounted
  useEffect(() => {
    document.title = "Products List";
    const fetchProducts = async () => {
      setIsLoading(true); // Loading starts now
      try {
        const response = await fetch(`${BASE_URL}`, {
          method: "GET",
        });
        const products = await response.json();
        setProductsList(products);
      } catch (error) {
        console.log(error);
        setError(error);
      } finally {
        setIsLoading(false); // loading is finished
      }
    };
    fetchProducts();
  }, []);

  // functions:

  // handleSelectedProducts: Call back function that adds or removes products from selected products array
  // will be passed as a call back to the productsList component, and hence to the checkboxes
  // checkboxes will call this function on change
  const handleSelectedProducts = (isSelected, sku) => {
    setSelectedProducts((prevSelectedProducts) => {
      if (isSelected) {
        // If product is selected, add it to the selected products array
        return [...prevSelectedProducts, sku]; // new array containing the previous SKUs AND the new one
      } else {
        // If product is not selected, filter it out from the array
        return prevSelectedProducts.filter((product) => product !== sku);
      }
    });
  };

  // handleMassDelete: call back function that handles sending the DELETE request to the API
  // passed to the Navbar button MASS DELETE and will be called on click
  const handleMassDelete = async () => {
    if (selectedProducts.length > 0) {
      const jsonArray = JSON.stringify(selectedProducts);

      try {
        const response = await fetch(`${BASE_URL}`, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: jsonArray,
        });
        const data = await response.json();
        // Filter out deleted products from the products list
        setProductsList((prevProducts) =>
          prevProducts.filter(
            (product) => !selectedProducts.includes(product.sku)
          )
        );

        setSelectedProducts([]); // Clear selected products after
      } catch (error) {
        console.error("Error: ", error);
      }
    } else {
      console.log("no checkbox selected");
    }
  };

  // view:
  return (
    <div>
      <Navbar title="Products List" src="/cart-window.svg">
        <NavLink link="/add-product" text="ADD" />
        <NavButton
          id="delete-product-btn"
          onClickFunction={handleMassDelete}
          text="MASS DELETE"
        />
      </Navbar>
      <Container>
        <h1 className="list-header">Product List</h1>
        <ProductList
          handleSelection={handleSelectedProducts}
          productsList={productsList}
          isLoading={isLoading}
          error={error}
        />
      </Container>
    </div>
  );
};

export default Homepage;
