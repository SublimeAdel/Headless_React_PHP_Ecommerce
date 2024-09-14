import React from "react";
import { Link } from "react-router-dom";
// navlink is a button that redirects the user somewhere else from the navbar
const NavLink = ({ link = "#", text }) => {
  return (
    <Link className="navButton" to={link}>
      {text}
    </Link>
  );
};

export default NavLink;
