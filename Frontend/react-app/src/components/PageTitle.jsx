import React from "react";

const PageTitle = ({ text = "", imgsrc = "/cart-window.svg" }) => {
  return (
    <div className="logo">
      <a href="/">
        <img className="logoImg" src={imgsrc} alt="Logo"></img>
      </a>
      <div className="page-title">{text}</div>
    </div>
  );
};

export default PageTitle;
