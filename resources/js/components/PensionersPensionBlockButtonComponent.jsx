import BlockIcon from "@mui/icons-material/Block";
import { Tooltip, Snackbar, Alert } from "@mui/material";
import { useRef, useState } from "react";
import { createPortal } from "react-dom";
import axios from "axios";
import WorkflowMessageFieldComponent from "./WorkflowMessageFieldComponent";

export default function PensionersPensionBlockButtonComponent({
    pensionId,
    pensionerId,
    pensionerName,
}) {
    const modalInstance = useRef(null);
    const [message, setMessage] = useState("");
    const [block, setBlock] = useState(false);
    const [error, setError] = useState(false);

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

    const handleBlocking = async () => {
        try {
            const response = await axios.post(
                `/api/pensioner/pension/block`,
                {
                    pension_id: pensionId,
                    pensioner_id: pensionerId,
                    block: true,
                    message,
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
            }
        } catch (error) {
            closeModal();
            setSnackbarMessage(error.response?.data?.message);
            setSnackbarSeverity("error");
            setSnackbarOpen(true);
        }
    };

    const handleSubmit = () => {
        if (!message.trim()) {
            setError(true);
            return;
        }
        setBlock(true);
        handleBlocking();
    };
    return (
        <>
            <button
                type="button"
                className="block-button"
                onClick={openModal}
                disabled={block}
            >
                <Tooltip title="Block Pension">
                    <BlockIcon fontSize="small" />
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
                                <h5 className="modal-title">Confirm Block</h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body">
                                Are you sure you want to block the pension of
                                <div className="fw-bold">{pensionerName}?</div>
                                <div className="mt-2">
                                    <WorkflowMessageFieldComponent
                                        value={message}
                                        onChange={(e) => {
                                            setMessage(e.target.value);
                                            setError(false);
                                        }}
                                        error={error}
                                        helperText={
                                            error
                                                ? "Block message is required"
                                                : ""
                                        }
                                    />
                                </div>
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
                                    Yes, Block
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
