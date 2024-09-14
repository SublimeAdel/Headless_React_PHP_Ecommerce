import React, { useEffect } from "react";
import Navbar from "../components/Navbar";
import NavButton from "../components/NavButton";
import Container from "../components/Container";
import Form from "../components/Form";
import NavLink from "../components/NavLink";
import { useState } from "react";
import Notification from "../components/Notification";
import { useNavigate } from "react-router-dom";
import Spinner from "../components/Spinner";

const AddProductPage = ({ baseURL }) => {
  const BASE_URL = baseURL;
  const navigate = useNavigate();
  // states:
  const [isLoading, setIsLoading] = useState(false);
  const [showNotification, setShowNotification] = useState(false);
  const [notification, setNotification] = useState(
    "Please, submit required data"
  );
  // initial error messages: * to show required
  const [validationErrors, setValidationErrors] = useState({
    sku: "*",
    name: "*",
    price: "*",
    type: "",
    weight: "*",
    size: "*",
    height: "*",
    width: "*",
    length: "*",
  });

  // effects:
  // useEffect to change the page title upon first mounting it
  useEffect(() => {
    document.title = "Add Product";
  }, []);

  // functions:
  // giveError: function to change an error message for a certain field
  const giveError = (field, error) => {
    setValidationErrors((prevState) => ({ ...prevState, [field]: error }));
  };

  // submitForm: function to send a post request with the product Object in its body
  // is called ONLY if all the data is valid and save button is pressed
  const submitForm = async (productObject) => {
    try {
      const response = await fetch(`${BASE_URL}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(productObject),
      });
      const responseMsg = await response.json();
      if (response.ok) {
        if (responseMsg.success) {
          setIsLoading(true);
          setTimeout(() => {
            // success: redirect back to homepage
            navigate("/");
          }, 200);
        }
      } else if (response.status === 400) {
        // in case of bad requests
        if (responseMsg.errors && responseMsg.errors[0].includes("SKU")) {
          giveError("sku", "SKU already exists");
        }
        setNotification(responseMsg.errors[0]); // notification carries the first error received from the API
        setShowNotification(true);
        setTimeout(() => {
          // show the notification for 5 seconds
          setShowNotification(false);
        }, 5000);
      }
    } catch (error) {
      console.error(error);
      setNotification("an unexpected error occured, please check the console");
      setShowNotification(true);
    }
  };

  /*  validateForm: function to perform input validation on the form inputs
    returns boolean true if the form data is valid, false otherwise
    also sets the notification message to be:
      -"Please, submit required data" if any required field is missing
      -"Please, provide the data of indicated type" if input was invalid e.g -ve dimensions or price */
  const validateForm = (form) => {
    const formData = new FormData(form);
    let valid = true;
    let hasEmptyField = false;

    // scour the data for any missing fields
    formData.forEach((value, key) => {
      if (value.trim() === "") hasEmptyField = true;
    });

    if (hasEmptyField) {
      //if any field is missing, form isnt valid and change notification text to "Please, submit required data"
      valid = false;
      setNotification("Please, submit required data");
    } else setNotification("Please, provide the data of indicated type");

    // individual field validation
    /*SKU: invalid if:
      - blank
    */
    if (formData.get("sku").trim() === "") {
      giveError("sku", "SKU is required");
    } else giveError("sku", "");

    /* name: invalid if:
      - blank 
      */
    if (formData.get("name").trim() === "") {
      giveError("name", "name is required");
    } else giveError("name", "");

    /* price invalid if negative */
    if (formData.get("price") < 0 || isNaN(formData.get("price"))) {
      giveError("price", "Price is required and must be a positive number");
      valid = false;
    } else giveError("price", "");

    if (formData.get("type").trim() === "") {
      giveError("type", "Please select a type");
      valid = false;
    } else giveError("type", "");

    /* attributes validation:
    weight invalid if negative
    size invalid if negative
    dimensions invalid if negative each
     */
    switch (formData.get("type")) {
      case "Furniture":
        let height = formData.get("attributes[Furniture][height]");
        let width = formData.get("attributes[Furniture][width]");
        let length = formData.get("attributes[Furniture][length]");
        if (height <= 0) {
          giveError("height", "height must be a positive number");
          valid = false;
        } else giveError("height", "");
        if (width <= 0) {
          giveError("width", "width must be a positive number");
          valid = false;
        } else giveError("width", "");
        if (length <= 0) {
          giveError("length", "length must be a positive number");
          valid = false;
        } else giveError("length", "");

        break;

      case "Book":
        let weight = formData.get("attributes[Book][weight]");
        if (weight <= 0) {
          giveError("weight", "weight must be a positive number");
          valid = false;
        } else giveError("weight", "");
        break;

      case "DVD":
        let size = formData.get("attributes[DVD][size]");
        if (size < 0) {
          giveError("size", "size must be a positive number");
          valid = false;
        } else giveError("size", "");
        break;

      default:
        valid = false;
        break;
    }
    // return true if all above doesnt apply
    return valid;
  };

  /* collectFromData: function that collects the input data from the Form and returns an object suitable for the API
    using these inputs, example object:
        {
        "sku": "sku545",
        "name": "productname",
        "price": 552,
        "type" : "DVD",
        "attributes": 
        {
            "DVD": {"size" : 299}
        }
    }     
  */
  const collectFormData = (form) => {
    const formData = new FormData(form); // create a FormData object to collect data from the form
    const formObject = {}; // new object to store the values from the form
    formData.forEach((value, key) => {
      formObject[key] = value; // copy the data from the form into the new object
    });

    // Collect additional attributes based on the selected type
    const type = formObject["type"];
    const attributes = {}; // attributes should be an object

    switch (type) {
      case "Book":
        attributes["Book"] = {
          weight: formObject["attributes[Book][weight]"],
        };
        break;
      case "DVD":
        attributes["DVD"] = { size: formObject["attributes[DVD][size]"] };
        break;
      case "Furniture":
        attributes["Furniture"] = {
          width: formObject["attributes[Furniture][width]"],
          length: formObject["attributes[Furniture][length]"],
          height: formObject["attributes[Furniture][height]"],
        };
        break;
      default: // error unknown type, probably will never reach this from front end
        console.error("Unknown type");
        return;
    }

    // Create the final JSON object to be sent to the API
    const jsonObject = {
      sku: formObject["sku"].trim(),
      name: formObject["name"].trim(),
      price: formObject["price"],
      type: formObject["type"],
      attributes: attributes, // "attributes" : { "type": {typeAttributes}}
    };
    return jsonObject;
  };

  /* onSubmitFunction: call back function called when SAVE button is clicked to submit the form 
     it will call the validateForm function to make sure the form is valid
     if the form inputs are valid it will call the submitForm function sending it the the object gathered from the inputs
     if form inputs are invalid it will show the notification for 5 seconds
  */
  const onSubmitFunction = (event) => {
    event.preventDefault();
    const productObject = collectFormData(event.target);
    if (validateForm(event.target)) {
      setShowNotification(false);
      submitForm(productObject); // send the gathered object to submitForm function to be sent in a POST method
    } else {
      setShowNotification(true);
      setTimeout(() => {
        setShowNotification(false);
      }, 5000);
    }
  };

  // views
  if (isLoading) {
    // if loading return a spinner
    return (
      <div className="empty-container">
        <Spinner />
      </div>
    );
  } else
    return (
      <div>
        <Navbar title="Product Add" src="/products-list.svg">
          <NavButton type="submit" form="product_form" text="SAVE" />
          <NavLink link="/" text={"CANCEL"} />
        </Navbar>
        <Container>
          <form
            id="product_form"
            className="product-form"
            onSubmit={onSubmitFunction}
          >
            <Form validationErrors={validationErrors} />
          </form>
          {showNotification && <Notification notificationText={notification} />}
        </Container>
      </div>
    );
};

export default AddProductPage;
