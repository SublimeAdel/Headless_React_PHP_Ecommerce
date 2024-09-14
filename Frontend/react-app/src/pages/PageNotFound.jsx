import React from "react";
import Container from "../components/Container";
import Navbar from "../components/Navbar";
import NavLink from "../components/NavLink";

const PageNotFound = () => {
  return (
    <>
      <Navbar title="Page Not Found" />
      <Container>
        <div className="page-not-found">
          <h1>404 Page Not Found</h1>
          No such page exists, please check the url
          <div className="goback">
            <NavLink text={"go back"} link={"/"} />
          </div>
        </div>
      </Container>
    </>
  );
};

export default PageNotFound;
