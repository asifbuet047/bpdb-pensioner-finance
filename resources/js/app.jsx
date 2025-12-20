import "../css/app.css";
import { createRoot } from "react-dom/client";
import Counter from "./components/Counter";

const el = document.getElementById("app");
if (el) {
    createRoot(el).render(<Counter />);
}
