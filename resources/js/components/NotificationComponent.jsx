import { useEffect, useState, useCallback } from "react";
import Badge from "@mui/material/Badge";
import Popover from "@mui/material/Popover";
import NotificationsIcon from "@mui/icons-material/Notifications";
import axios from "axios";

export default function NotificationComponent() {
    const [anchorEl, setAnchorEl] = useState(null);
    const [count, setCount] = useState(0);

    const open = Boolean(anchorEl);

    const handleClick = useCallback((event) => {
        setAnchorEl(event.currentTarget);
    }, []);

    const handleClose = useCallback(() => {
        setAnchorEl(null);
    }, []);

    const handleNotificationClick = () => {
        window.location.href = "/pensioners/all";
    };

    useEffect(() => {
        let isMounted = true;

        const fetchPendingCount = async () => {
            try {
                const response = await axios.get("/api/officer/pending", {
                    withCredentials: true,
                });

                if (isMounted && response?.data?.success) {
                    setCount(response.data.data ?? 0);
                }
            } catch (error) {
                if (isMounted) {
                    setCount(0);
                    console.error("Failed to load notifications", error);
                }
            }
        };

        fetchPendingCount();

        return () => {
            isMounted = false;
        };
    }, []);

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
                anchorOrigin={{ vertical: "bottom", horizontal: "center" }}
                transformOrigin={{ vertical: "top", horizontal: "left" }}
            >
                <div className="p-3" style={{ width: 250 }}>
                    <h6 className="mb-2">Notifications</h6>
                    {count > 0 ? (
                        <div
                            className="small text-decoration-underline"
                            style={{ cursor: "pointer" }}
                            onClick={handleNotificationClick}
                        >
                            You have {count} pending task
                            {count > 1 ? "s" : ""}
                        </div>
                    ) : (
                        <div className="text-muted small">No new task</div>
                    )}
                </div>
            </Popover>
        </>
    );
}
