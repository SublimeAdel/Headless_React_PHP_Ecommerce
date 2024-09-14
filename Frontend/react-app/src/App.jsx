import React from "react";
import Homepage from "./pages/Homepage";
import AddProductPage from "./pages/AddProductPage";
import PageNotFound from "./pages/PageNotFound";
import {
  Route,
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
} from "react-router-dom";

const App = () => {
  const BASE_URL = "http://localhost/backendAPI/main.php"; // API base URL to be sent to both page components
  const router = createBrowserRouter(
    createRoutesFromElements(
      <>
        <Route index element={<Homepage baseURL={BASE_URL} />} />
        <Route
          path="/add-product"
          element={<AddProductPage baseURL={BASE_URL} />}
        />
        <Route path="*" element={<PageNotFound />} />
      </>
    )
  );

  return <RouterProvider router={router} />;
};

export default App;
