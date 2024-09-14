import React from "react";

const NavButton = ({
  onClickFunction,
  text,
  type = "button",
  form = undefined,
  id = undefined,
}) => {
  return (
    <button
      type={type}
      className="navButton"
      onClick={onClickFunction}
      form={form}
      id={id}
    >
      {text}
    </button>
  );
};

export default NavButton;
