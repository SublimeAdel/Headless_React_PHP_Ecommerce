import React from "react";
import { useState, useEffect } from "react";
import InputField from "./InputField";
import DynamicInput from "./DynamicInput";
import TypeSwitcher from "./TypeSwitcher";

const Form = ({ validationErrors }) => {
  const [selectedOption, setSelectedOption] = useState();

  const onChangeType = (event) => {
    setSelectedOption(event.target.value);
  };

  return (
    <>
      <InputField
        type="text"
        id="sku"
        name="sku"
        label="SKU"
        placeholder="Please enter SKU"
        errMsg={validationErrors.sku}
      />
      <InputField
        type="text"
        id="name"
        name="name"
        label="Name"
        placeholder="Please enter name"
        errMsg={validationErrors.name}
      />
      <InputField
        type="number"
        step="any"
        // min="0"
        id="price"
        name="price"
        label="Price"
        placeholder="Please enter price"
        errMsg={validationErrors.price}
      />

      <TypeSwitcher
        onChangeFunction={onChangeType}
        errMsg={validationErrors.type}
      />
      <DynamicInput
        value={selectedOption}
        validationErrors={validationErrors}
      />
    </>
  );
};

export default Form;
