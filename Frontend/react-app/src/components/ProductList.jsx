import React from "react";
import ProductItem from "./ProductItem";
import { AnimatePresence } from "framer-motion";
import Spinner from "./Spinner";

const ProductList = ({
  handleSelection,
  productsList = [],
  isLoading = true,
  error = null,
}) => {
  if (isLoading) {
    return (
      <div className="empty-container">
        <Spinner />
      </div>
    );
  }

  if (error) {
    console.error(error);
    return (
      <div className="page-not-found">
        <h1>Something went wrong</h1>
        Please try again. {error}
      </div>
    );
  }

  return (
    <div className="product-list" id="productList">
      <AnimatePresence>
        {productsList.map((product) => (
          <ProductItem
            key={product.sku}
            sku={product.sku}
            name={product.name}
            price={product.price}
            attributes={product.attributes}
            handleSelection={handleSelection}
          />
        ))}
      </AnimatePresence>
    </div>
  );
};

export default ProductList;
