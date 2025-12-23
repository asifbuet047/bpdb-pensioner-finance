import ArrowForwardIcon from "@mui/icons-material/ArrowForward";
import { Tooltip } from "@mui/material";
import { useEffect } from "react";

export default function ForwardButtonComponent({ id }) {
    console.log(id);

    useEffect(() => {
        console.log("Forward button rendered successfully");
    }, []);
    return (
        <div className="d-flex gap-2 justify-content-center">
            <button className="custom-button-fill">
                <Tooltip title="Forward Pensioner">
                    <ArrowForwardIcon fontSize="small" />
                </Tooltip>
            </button>
        </div>
    );
}
