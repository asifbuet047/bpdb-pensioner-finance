import DeleteIcon from '@mui/icons-material/Delete';
import { Tooltip, Snackbar, Alert } from '@mui/material';
import { useRef, useState } from 'react';
import { createPortal } from 'react-dom';
import axios from 'axios';

export default function PensionDeleteButtonComponent({ pensionId, totalAmount, buttonStatus }) {
    const modalInstance = useRef(null);
    const button_status = buttonStatus === 'true';

    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState('');
    const [snackbarSeverity, setSnackbarSeverity] = useState('error');

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

    const handleDelete = async () => {
        try {
            const response = await axios.delete(`/pension/${pensionId}`, {
                withCredentials: true,
            });

            if (response.data.success) {
                closeModal();
                setSnackbarMessage(response.data.message);
                setSnackbarSeverity('success');
                setSnackbarOpen(true);
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            }
        } catch (error) {
            closeModal();

            setSnackbarMessage(error.response?.data?.message || 'Failed to delete pension');
            setSnackbarSeverity('error');
            setSnackbarOpen(true);
        }
    };

    return (
        <>
            <button
                type="button"
                className="delete-button"
                onClick={openModal}
                disabled={button_status}
            >
                <Tooltip title="Delete Pensioner">
                    <DeleteIcon fontSize="small" />
                </Tooltip>
            </button>

            {createPortal(
                <div className="modal fade" ref={setModalRef} tabIndex="-1" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">Confirm Delete</h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body">
                                Are you sure you want to delete this pension which total amount is
                                name is
                                <div className="fw-bold">{totalAmount}?</div>
                            </div>

                            <div className="modal-footer">
                                <button className="btn btn-secondary" onClick={closeModal}>
                                    Cancel
                                </button>
                                <button className="btn btn-danger" onClick={handleDelete}>
                                    Yes, Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>,
                document.body,
            )}

            <Snackbar
                open={snackbarOpen}
                autoHideDuration={4000}
                onClose={() => setSnackbarOpen(false)}
                anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
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
