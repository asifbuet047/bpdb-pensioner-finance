import DoneOutlineIcon from "@mui/icons-material/DoneOutline";
import { Tooltip, Snackbar, Alert } from "@mui/material";
import { useRef, useState } from "react";
import { createPortal } from "react-dom";
import axios from "axios";
import WorkflowMessageFieldComponent from "./WorkflowMessageFieldComponent";

export default function InitiatorGeneratedPensionButtonComponent({
    pensionData,
}) {
    const modalInstance = useRef(null);
    console.log(pensionData);

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

    const handleAddPension = async () => {
        try {
            const response = await axios.post(
                `/api/pensioners/pension/approved`,
                {
                    month: pensionData.month,
                    year: pensionData.year,
                    onlybonus: pensionData.onlybonus,
                    banglanewyearbonus: pensionData.banglanewyearbonus,
                    muslim_bonus: pensionData.muslim_bonus,
                    hindu_bonus: pensionData.hindu_bonus,
                    christian_bonus: pensionData.christian_bonus,
                    buddhist_bonus: pensionData.buddhist_bonus,
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

    const handleSubmit = async () => {
        if (!message.trim()) {
            setError(true);
            return;
        }
    };

    return (
        <div className="text-center mt-4">
            <button
                type="button"
                className="btn btn-primary btn-lg me-2 shadow-sm"
                onClick={openModal}
            >
                Initialize Generated Pension
            </button>

            <button
                type="button"
                className="btn btn-outline-primary btn-lg shadow-sm"
                onClick={() => window.location.reload()}
            >
                Refresh List
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
                                    Confirm Pension Generation
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body">
                                Are you sure you want to generate this pension?
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
                                    onClick={handleSubmit}
                                >
                                    Yes, Generate Pension
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
        </div>
    );
}
