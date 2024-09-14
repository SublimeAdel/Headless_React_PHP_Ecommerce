import React from "react";

const InputField = ({
  name,
  id,
  type,
  placeholder,
  label,
  onChangeFunction,
  errMsg = "",
  min, // for numbers
  step, // to allow float
}) => {
  return (
    <div className="inputfield">
      <label htmlFor={id}>{label}</label>
      <div>
        <input
          className="inputs"
          style={{ backgroundColor: "white" }}
          type={type}
          placeholder={placeholder}
          id={id}
          name={name}
          onBlur={onChangeFunction}
          required
          min={min}
          step={step}
        />
        <span className="error-msg">{errMsg}</span>
      </div>
    </div>
  );
};

export default InputField;
