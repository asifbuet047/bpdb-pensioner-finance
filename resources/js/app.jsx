import "../css/app.css";
import { createRoot } from "react-dom/client";
import Custom from "./components/Custom";

const el = document.getElementById("app");
if (el) {
    createRoot(el).render(<Custom />);
}
