import DoneOutlineIcon from "@mui/icons-material/DoneOutline";
import { Tooltip } from "@mui/material";
import { useEffect } from "react";

export default function ApproveButtonComponent({ id }) {
    console.log(id);

    useEffect(() => {
        console.log("Approve button rendered successfully");
    }, []);
    return (
        <div className="d-flex gap-2 justify-content-center">
            <button className="custom-button-fill">
                <Tooltip title="Approve Pensioner">
                    <DoneOutlineIcon fontSize="small" />
                </Tooltip>
            </button>
        </div>
    );
}
