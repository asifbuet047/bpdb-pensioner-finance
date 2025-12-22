import { useState } from "react";
import Badge from "@mui/material/Badge";
import Popover from "@mui/material/Popover";
import NotificationsIcon from "@mui/icons-material/Notifications";

export default function NotificationComponent() {
    const [anchorEl, setAnchorEl] = useState(null);
    const [count, setCount] = useState(0);

    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const open = Boolean(anchorEl);

    return (
        <>
            <Badge
                badgeContent={count}
                color="secondary"
                onClick={handleClick}
                sx={{ cursor: "pointer" }}
            >
                <NotificationsIcon />
            </Badge>

            <Popover
                open={open}
                anchorEl={anchorEl}
                onClose={handleClose}
                anchorOrigin={{
                    vertical: "bottom",
                    horizontal: "center",
                }}
                transformOrigin={{
                    vertical: "top",
                    horizontal: "left",
                }}
            >
                <div className="p-3" style={{ width: "250px" }}>
                    <h6 className="mb-2">Notifications</h6>
                    <div className="text-muted small">No new notifications</div>
                </div>
            </Popover>
        </>
    );
}
