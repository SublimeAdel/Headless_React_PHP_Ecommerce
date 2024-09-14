import React, { useEffect, useState } from "react";
import InputField from "./InputField";

const DynamicInput = ({ value, validationErrors }) => {
  /* states */
  const [type, setType] = useState("");

  useEffect(() => {
    setType(value);
  }, [value]);

  /* views change dynamically according to the type selected by the switcher */

  if (type === "Furniture") {
    // if type is Furniture render Furniture inputs: height, width, length
    return (
      <div>
        <div className="product-description">Please, provide dimensions:</div>
        <InputField
          key={`${type}-height`}
          type="number"
          // min="0"
          name="attributes[Furniture][height]"
          label="Height"
          id="height"
          placeholder="Please enter height"
          errMsg={validationErrors.height}
        />
        <InputField
          key={`${type}-width`}
          type="number"
          // min="0"
          name="attributes[Furniture][width]"
          label="Width"
          id="width"
          placeholder="Please enter width"
          errMsg={validationErrors.width}
        />
        <InputField
          key={`${type}-length`}
          type="number"
          // min="0"
          name="attributes[Furniture][length]"
          label="Length"
          id="length"
          placeholder="Please enter length"
          errMsg={validationErrors.length}
        />
      </div>
    );
  } else if (type === "DVD") {
    return (
      // if type is DVD render DVD inputs: size

      <div>
        <div className="product-description">Please, provide size:</div>
        <InputField
          key={`${type}-size`}
          type="number"
          // min="0"
          name="attributes[DVD][size]"
          label="Size"
          id="size"
          placeholder="Please enter size"
          errMsg={validationErrors.size}
        />
      </div>
    );
  } else if (type === "Book") {
    // if type is Book render Book inputs: weight

    return (
      <div>
        <div className="product-description">Please, provide weight:</div>
        <InputField
          key={`${type}-weight`}
          type="number"
          // min="0"
          step="any"
          name="attributes[Book][weight]"
          label="Weight"
          id="weight"
          placeholder="Please enter weight"
          errMsg={validationErrors.weight}
        />
      </div>
    );
  } else return;
};

export default DynamicInput;
