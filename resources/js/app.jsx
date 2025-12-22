import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import "./helper";
import "../css/app.css";
import { createRoot } from "react-dom/client";
import NotificationComponent from "./components/NotificationComponent";

const el = document.getElementById("react-app");

if (el) {
    console.log("React is successfully integrated");
    createRoot(el).render(<NotificationComponent />);
} else {
    console.log("React integration into react-app element failed");
}
