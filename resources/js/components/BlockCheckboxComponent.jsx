import TaskAltOutlinedIcon from '@mui/icons-material/TaskAltOutlined';
import { Tooltip } from '@mui/material';
import { useState } from 'react';

export default function BlockCheckboxComponent({ disabled = false }) {
    const [checked, setChecked] = useState(true);

    const handleToggle = () => {
        if (disabled) return;
        setChecked((prev) => !prev);
    };

    return (
        <div className="tick-wrapper d-inline-flex align-items-center">
            <div
                className={`form-check tick-check 
                    ${checked ? 'checked' : ''} 
                    ${disabled ? 'disabled' : ''}`}
                onClick={handleToggle}
            >
                <input
                    type="checkbox"
                    className="form-check-input d-none"
                    readOnly
                    disabled={disabled}
                    checked
                />

                <Tooltip title={disabled ? 'Action disabled' : 'Mark as Blocked'}>
                    <span className="tick-icon">
                        <TaskAltOutlinedIcon fontSize="small" />
                    </span>
                </Tooltip>
            </div>
        </div>
    );
}
