import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import "./helper";
import "../css/app.css";
import { createRoot } from "react-dom/client";
import NotificationComponent from "./components/NotificationComponent";
import DeleteButtonComponent from "./components/DeleteButtonComponent";
import PensionerActionButtonsComponent from "./components/PensionerActionButtonsComponent";

const el = document.getElementById("notification");

if (el) {
    console.log("React notification is successfully integrated");
    createRoot(el).render(<NotificationComponent />);
} else {
    console.log("React integration into react-app element failed");
}

document.querySelectorAll(".react-pensionar-action-buttons").forEach((el) => {
    createRoot(el).render(
        <PensionerActionButtonsComponent
            officerRole={el.dataset.officerRole}
            pensionersType={el.dataset.pensionersType}
        />
    );
});
