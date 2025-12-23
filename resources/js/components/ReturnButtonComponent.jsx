import ArrowBackIcon from "@mui/icons-material/ArrowBack";
import { Tooltip } from "@mui/material";
import { useEffect } from "react";

export default function ReturnButtonComponent({ id }) {
    console.log(id);
    useEffect(() => {
        console.log("Return button rendered successfully");
    }, []);
    return (
        <div className="d-flex gap-2 justify-content-center">
            <button className="custom-button-fill">
                <Tooltip title="Return Pensioner">
                    <ArrowBackIcon fontSize="small" />
                </Tooltip>
            </button>
        </div>
    );
}
