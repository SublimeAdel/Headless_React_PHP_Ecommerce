import React from "react";

const TypeSwitcher = ({ onChangeFunction, errMsg = "" }) => {
  return (
    <div className="inputfield">
      <label htmlFor="productType">Type</label>
      <select
        id="productType"
        name="type"
        required
        onChange={onChangeFunction}
        defaultValue=""
      >
        <option value="" disabled>
          Select type
        </option>
        <option value="DVD">DVD</option>
        <option value="Book">Book</option>
        <option value="Furniture">Furniture</option>
      </select>
      <span className="error-msg">{errMsg}</span>
    </div>
  );
};

export default TypeSwitcher;
