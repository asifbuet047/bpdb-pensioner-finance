import DeleteIcon from "@mui/icons-material/Delete";
import EditIcon from "@mui/icons-material/Edit";
import ArrowForwardIcon from "@mui/icons-material/ArrowForward";
import ArrowBackIcon from "@mui/icons-material/ArrowBack";
import DoneOutlineIcon from "@mui/icons-material/DoneOutline";
import { Tooltip } from "@mui/material";

export default function PensionerActionButtonsComponent({
    officerRole,
    pensionersType,
}) {
    switch (officerRole) {
        case "initiator":
            return (
                <div className="d-flex gap-2 justify-content-center">
                    {pensionersType == "initiated" && (
                        <>
                            <button className="custom-button-fill">
                                <Tooltip title="Delete Pensioner">
                                    <DeleteIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill">
                                <Tooltip title="Edit Pensioner">
                                    <EditIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill">
                                <Tooltip title="Forward">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "certified" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Return Pensioner">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Forward for Approval">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "approved" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Return Pensioner to Certifier">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Approve">
                                    <DoneOutlineIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                </div>
            );

        case "certificer":
            return (
                <div className="d-flex gap-2 justify-content-center">
                    {pensionersType == "initiated" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Delete Pensioner">
                                    <DeleteIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Edit Pensioner">
                                    <EditIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Forward">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "certified" && (
                        <>
                            <button className="custom-button-fill">
                                <Tooltip title="Return Pensioner">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill">
                                <Tooltip title="Forward for Approval">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "approved" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Return Pensioner to Certifier">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Approve">
                                    <DoneOutlineIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                </div>
            );
        case "approver":
            return (
                <div className="d-flex gap-2 justify-content-center">
                    {pensionersType == "initiated" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Delete Pensioner">
                                    <DeleteIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Edit Pensioner">
                                    <EditIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Forward">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "certifier" && (
                        <>
                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Return Pensioner">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill" disabled>
                                <Tooltip title="Forward for Approval">
                                    <ArrowForwardIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                    {pensionersType == "approved" && (
                        <>
                            <button className="custom-button-fill">
                                <Tooltip title="Return Pensioner to Certifier">
                                    <ArrowBackIcon fontSize="small" />
                                </Tooltip>
                            </button>

                            <button className="custom-button-fill">
                                <Tooltip title="Approve">
                                    <DoneOutlineIcon fontSize="small" />
                                </Tooltip>
                            </button>
                        </>
                    )}
                </div>
            );

        default:
            return <div></div>;
    }
}
