import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import axios from "axios";
import "./helper";
import "../css/app.css";
import { createRoot } from "react-dom/client";
import NotificationComponent from "./components/NotificationComponent";
import DeleteButtonComponent from "./components/DeleteButtonComponent";
import EditButtonComponent from "./components/EditButtonComponent";
import ForwardButtonComponent from "./components/ForwardButtonComponent";
import ReturnButtonComponent from "./components/ReturnButtonComponent";
import ApproveButtonComponent from "./components/ApproveButtonComponent";
import UpdateSuccessSnackbar from "./components/UpdateSuccessSnackbar";
import * as bootstrap from "bootstrap";
import WorkflowButtonComponent from "./components/WorkflowButtonComponent";
import BlockCheckboxComponent from "./components/BlockCheckboxComponent";
import MonthlyGeneratePensionComponent from "./components/MonthlyGeneratePensionComponent";

axios.defaults.withCredentials = true;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.bootstrap = bootstrap;

const el = document.getElementById("notification");
if (el) {
    console.log("React notification is successfully integrated");
    createRoot(el).render(<NotificationComponent />);
} else {
    console.log("React integration into react-app element failed");
}

document.querySelectorAll(".pensioner-update-button").forEach((el) => {
    createRoot(el).render(
        <EditButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />
    );
});

document.querySelectorAll(".pensioner-delete-button").forEach((el) => {
    createRoot(el).render(
        <DeleteButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />
    );
});

document.querySelectorAll(".pensioner-forward-button").forEach((el) => {
    createRoot(el).render(
        <ForwardButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />
    );
});

document.querySelectorAll(".pensioner-return-button").forEach((el) => {
    createRoot(el).render(
        <ReturnButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />
    );
});

document.querySelectorAll(".pensioner-approve-button").forEach((el) => {
    createRoot(el).render(
        <ApproveButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />
    );
});

document.querySelectorAll(".pensioner-workflow-button").forEach((el) => {
    createRoot(el).render(
        <WorkflowButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
        />
    );
});

document.querySelectorAll(".pensioner-block-checkbox").forEach((el) => {
    createRoot(el).render(<BlockCheckboxComponent disabled={false} />);
});

const snackbarEl = document.getElementById("update-success-snackbar");

if (snackbarEl) {
    createRoot(snackbarEl).render(<UpdateSuccessSnackbar />);
}

const monthlyPension = document.getElementById("monthly-pension-generation");
if (monthlyPension) {
    createRoot(monthlyPension).render(<MonthlyGeneratePensionComponent />);
}
