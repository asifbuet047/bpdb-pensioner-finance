import React, { useEffect, useState } from 'react';
import { Snackbar, Alert } from '@mui/material';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import axios from 'axios';

export default function OfficeSelectionAutocompleteComponent() {
    const [offices, setoffices] = useState([]);
    const [selectedOfficeId, setSelectedOfficeId] = useState(100);

    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState('');
    const [snackbarSeverity, setSnackbarSeverity] = useState('error');

    useEffect(() => {
        const controller = new AbortController();

        const fetchWorkflow = async () => {
            try {
                const response = await axios.get(`/api/offices`, {
                    withCredentials: true,
                    signal: controller.signal,
                });

                if (response.data?.success) {
                    setoffices(response.data.data ?? []);
                    setSnackbarMessage(response.data.message);
                    setSnackbarSeverity('success');
                    setSnackbarOpen(true);
                }
            } catch (error) {
                if (!axios.isCancel(error)) {
                    setSnackbarMessage('Failed to load workflow data');
                    setSnackbarSeverity('error');
                    setSnackbarOpen(true);
                }
            }
        };

        fetchWorkflow();

        return () => controller.abort();
    }, []);
    return (
        <>
            <Autocomplete
                options={offices}
                fullWidth
                getOptionLabel={(option) => option.name_in_english || 'Unnamed Office'}
                isOptionEqualToValue={(option, value) => option.id === value.id}
                onChange={(event, newValue) => {
                    setSelectedOfficeId(newValue.id);
                }}
                renderOption={(props, option) => (
                    <li {...props} key={option.id}>
                        <div style={{ display: 'flex', flexDirection: 'column' }}>
                            <strong>{option.name_in_english}</strong>
                            <span style={{ fontSize: '12px', color: '#666' }}>
                                Code: {option.office_code}
                            </span>
                        </div>
                    </li>
                )}
                renderInput={(params) => (
                    <TextField {...params} label="Select an office" fullWidth />
                )}
            />
            <input type="hidden" name="office_id" value={selectedOfficeId || ''} />
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
