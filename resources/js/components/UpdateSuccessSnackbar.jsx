// resources/js/components/UpdateSuccessSnackbar.jsx
import { Snackbar, Alert } from "@mui/material";
import { useEffect, useState } from "react";

export default function UpdateSuccessSnackbar() {
    const [open, setOpen] = useState(false);

    useEffect(() => {
        if (window.__PENSIONER_UPDATE_SUCCESS__) {
            setOpen(true);
            delete window.__PENSIONER_UPDATE_SUCCESS__;
        }
    }, []);

    return (
        <Snackbar
            open={open}
            autoHideDuration={4000}
            onClose={() => setOpen(false)}
            anchorOrigin={{ vertical: "top", horizontal: "right" }}
        >
            <Alert
                onClose={() => setOpen(false)}
                severity="success"
                variant="filled"
            >
                Pensioner updated successfully
            </Alert>
        </Snackbar>
    );
}
