import "./helper";
import "../css/app.css";
import { createRoot } from "react-dom/client";
import Counter from "./components/Counter";

const el = document.getElementById("react-app");

if (el) {
    console.log("React is successfully integrated");
    createRoot(el).render(<Counter />);
} else {
    console.log("React integration failed");
}
