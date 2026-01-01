import InsertCommentIcon from "@mui/icons-material/InsertComment";
import { Tooltip, Snackbar, Alert } from "@mui/material";
import { useEffect, useRef, useState, useCallback } from "react";
import { createPortal } from "react-dom";
import axios from "axios";

export default function PensionWorkflowButtonComponent({
    pensionId,
    totalAmount,
}) {
    const modalInstance = useRef(null);

    const [workflowCount, setWorkflowCount] = useState(0);

    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState("");
    const [snackbarSeverity, setSnackbarSeverity] = useState("error");

    const setModalRef = useCallback((node) => {
        if (node && !modalInstance.current && window.bootstrap) {
            modalInstance.current = new window.bootstrap.Modal(node);
        }
    }, []);

    const openModal = () => modalInstance.current?.show();
    const closeModal = () => modalInstance.current?.hide();

    useEffect(() => {
        if (!pensionId) return;

        const controller = new AbortController();

        const fetchWorkflow = async () => {
            try {
                const response = await axios.get(
                    `/api/pension/workflow/${pensionId}`,
                    {
                        withCredentials: true,
                        signal: controller.signal,
                    }
                );

                if (response.data?.success) {
                    setWorkflowCount(response.data.data ?? 0);
                }
            } catch (error) {
                if (!axios.isCancel(error)) {
                    setSnackbarMessage("Failed to load workflow data");
                    setSnackbarSeverity("error");
                    setSnackbarOpen(true);
                }
            }
        };

        fetchWorkflow();

        return () => controller.abort();
    }, [pensionId]);

    const handleSubmit = () => {
        window.location.href = `/pension/workflow?id=${pensionId}`;
    };

    return (
        <>
            <Tooltip title="View Approval Workflow">
                <span>
                    <button
                        type="button"
                        className="approve-button"
                        onClick={openModal}
                        disabled={workflowCount === 0}
                    >
                        <InsertCommentIcon fontSize="small" />
                    </button>
                </span>
            </Tooltip>

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
                                    View approval workflow?
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                />
                            </div>

                            <div className="modal-body">
                                Are you sure you want to view pension no{" "}
                                <strong>{pensionId}</strong>'s approval
                                workflow?
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
                                    Yes, View
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
