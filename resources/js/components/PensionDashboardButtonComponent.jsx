import DashboardIcon from "@mui/icons-material/Dashboard";
import { Tooltip, Snackbar, Alert } from "@mui/material";
import { useRef, useState } from "react";
import { createPortal } from "react-dom";
import axios from "axios";
import WorkflowMessageFieldComponent from "./WorkflowMessageFieldComponent";

export default function PensionDashboardButtonComponent({
    pensionId,
    totalAmount,
}) {
    const modalInstance = useRef(null);

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

    const handleDashboadView = async () => {
        try {
            const response = await axios.get(`/api/pension?id=${pensionId}`, {
                withCredentials: true,
            });

            if (response.data.success) {
                closeModal();
                setSnackbarMessage(response.data.message);
                setSnackbarSeverity("success");
                setSnackbarOpen(true);
                setTimeout(() => {
                    window.location.href = `/pension/dashboard/${pensionId}`;
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
                className="approve-button"
                onClick={openModal}
            >
                <Tooltip title="Dashboard of Pension">
                    <DashboardIcon fontSize="small" />
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
                                    Want to View Pension?
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body">
                                Are you sure you want to view this pension{" "}
                                <div className="fw-bold">{totalAmount}?</div>
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
                                    onClick={handleDashboadView}
                                >
                                    Yes, View Pension
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
