import React from "react";
import PageTitle from "./PageTitle";

const Navbar = ({ children, title, src }) => {
  return (
    <nav className="navbar">
      <div className="navbarItem" id="logo">
        <PageTitle text={title} imgsrc={src} />
      </div>
      <div className="navbarItem">{children}</div>
    </nav>
  );
};

export default Navbar;
