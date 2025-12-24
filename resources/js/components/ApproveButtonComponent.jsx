import DoneOutlineIcon from "@mui/icons-material/DoneOutline";
import { Tooltip, Snackbar, Alert } from "@mui/material";
import { useRef, useState } from "react";
import { createPortal } from "react-dom";
import axios from "axios";

export default function ApproveButtonComponent({
    pensionerId,
    pensionerName,
    buttonStatus,
}) {
    const modalInstance = useRef(null);
    const button_status = buttonStatus === "true";

    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState("");
    const [snackbarSeverity, setSnackbarSeverity] = useState("error");

    const setModalRef = (node) => {
        if (node && !modalInstance.current && window.bootstrap) {
            modalInstance.current = new window.bootstrap.Modal(node);
        }
    };

    const openModal = () => {
        modalInstance.current?.show();
    };

    const closeModal = () => {
        modalInstance.current?.hide();
    };

    const handleForward = async () => {
        try {
            const response = await axios.post(
                `/api/pensioner/workflow/`,
                {
                    workflow: "approve",
                    id: pensionerId,
                },
                {
                    withCredentials: true,
                }
            );

            if (response.data.success) {
                closeModal();
                setSnackbarMessage(response.data.message);
                setSnackbarSeverity("success");
                setSnackbarOpen(true);
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            }
        } catch (error) {
            closeModal();
            setSnackbarMessage(error.response?.data?.message);
            setSnackbarSeverity("error");
            setSnackbarOpen(true);
        }
    };

    return (
        <>
            <button
                type="button"
                className="custom-button-fill"
                onClick={openModal}
                disabled={button_status}
            >
                <Tooltip title="Forward Pensioner">
                    <DoneOutlineIcon fontSize="small" />
                </Tooltip>
            </button>

            {createPortal(
                <div
                    className="modal fade"
                    ref={setModalRef}
                    tabIndex="-1"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">
                                    Confirm Approval
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body">
                                Are you sure you want to approve this pensioner
                                <div className="fw-bold">{pensionerName}?</div>
                            </div>

                            <div className="modal-footer">
                                <button
                                    className="btn btn-secondary"
                                    onClick={closeModal}
                                >
                                    Cancel
                                </button>
                                <button
                                    className="btn btn-success"
                                    onClick={handleForward}
                                >
                                    Yes, Approve
                                </button>
                            </div>
                        </div>
                    </div>
                </div>,
                document.body
            )}

            <Snackbar
                open={snackbarOpen}
                autoHideDuration={4000}
                onClose={() => setSnackbarOpen(false)}
                anchorOrigin={{ vertical: "top", horizontal: "right" }}
            >
                <Alert
                    onClose={() => setSnackbarOpen(false)}
                    severity={snackbarSeverity}
                    variant="filled"
                >
                    {snackbarMessage}
                </Alert>
            </Snackbar>
        </>
    );
}
