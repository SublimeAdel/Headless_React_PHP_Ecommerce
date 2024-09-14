import React from "react";
import { useState, useEffect } from "react";
import { motion } from "framer-motion";

const ProductItem = ({ sku, name, price, attributes, handleSelection }) => {
  const [isSelected, setIsSelected] = useState(false);

  return (
    <motion.div
      layout // elements will now smoothly assume their new positions
      initial={{ opacity: 0, y: 40 }} // Start invisible and below the list
      animate={{ opacity: 1, y: 0 }} // Animate to full opacity and position
      exit={{ opacity: 0, y: -20 }} // Fade out and slide up on exit
      transition={{ duration: 0.3 }} // Transition duration
    >
      <div
        className={` product-item ${isSelected ? "selected" : ""} `}
        id={sku}
      >
        <input
          className="delete-checkbox"
          type="checkbox"
          name="sku[]"
          value={sku}
          onChange={() => {
            setIsSelected(!isSelected);
            handleSelection(!isSelected, sku);
          }}
        />
        <span className="product-data">
          {sku} <br />
          {name} <br />
          {price} $ <br />
          {attributes} <br />
        </span>
      </div>
    </motion.div>
  );
};

export default ProductItem;
