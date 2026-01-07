import * as React from 'react';
import { TextField } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import dayjs from 'dayjs';

export default function DatePickerComponent({ name = '' }) {
    const [selectedDate, setSelectedDate] = React.useState(null);
    return (
        <div>
            <LocalizationProvider dateAdapter={AdapterDayjs}>
                <DatePicker
                    label="Select Date"
                    value={selectedDate}
                    onChange={(newValue) => setSelectedDate(newValue)}
                    renderInput={(params) => (
                        <TextField {...params} fullWidth sx={{ width: '100%' }} />
                    )}
                />
            </LocalizationProvider>

            <input
                type="hidden"
                name={name}
                value={selectedDate ? dayjs(selectedDate).format('YYYY-MM-DD') : ''}
            />
        </div>
    );
}
