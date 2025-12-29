import axios from "axios";
import { useState } from "react";
import { Tooltip, Snackbar, Alert } from "@mui/material";

export default function MonthlyGeneratePensionComponent() {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    const currentMonth = months[new Date().getMonth()];
    const [month, setMonth] = useState(currentMonth);
    const [year, setYear] = useState(new Date().getFullYear());
    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState("");
    const [snackbarSeverity, setSnackbarSeverity] = useState("error");

    const currentYear = new Date().getFullYear();
    const isValid = month && year;

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post(
                `/api/pensioners/approved`,
                {
                    month,
                    year,
                },
                {
                    withCredentials: true,
                }
            );

            if (response.data.success) {
                setSnackbarMessage(response.data.message);
                setSnackbarSeverity("success");
                setSnackbarOpen(true);
                setTimeout(() => {
                    window.location.href = `/view/pensioners/approved?month=${month}&year=${year}`;
                }, 1200);
            }
        } catch (error) {
            setSnackbarMessage(error.response?.data?.message);
            setSnackbarSeverity("error");
            setSnackbarOpen(true);
        }
    };

    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-lg-9">
                    <div className="card shadow-lg border-0 rounded-4">
                        <div className="card-header bg-primary bg-gradient text-white rounded-top-4 py-3">
                            <h5 className="mb-0 d-flex align-items-center">
                                <i className="bi bi-cash-coin fs-4 me-2"></i>
                                Monthly Pension Generation Report
                            </h5>
                        </div>

                        <div className="card-body p-4">
                            <form onSubmit={handleSubmit}>
                                <div className="row g-4 align-items-stretch">
                                    <div className="col-md-4">
                                        <div className="p-3 bg-light rounded-3 h-100 border">
                                            <div className="mb-3">
                                                <label className="form-label fw-semibold">
                                                    <i className="bi bi-calendar-month me-1 text-primary"></i>
                                                    Pension Month
                                                </label>
                                                <select
                                                    className="form-select"
                                                    value={month}
                                                    onChange={(e) =>
                                                        setMonth(e.target.value)
                                                    }
                                                >
                                                    <option value="">
                                                        -- Select Month --
                                                    </option>
                                                    {months.map((m, index) => (
                                                        <option
                                                            key={index}
                                                            value={m}
                                                        >
                                                            {m}
                                                        </option>
                                                    ))}
                                                </select>
                                            </div>

                                            <div>
                                                <label className="form-label fw-semibold">
                                                    <i className="bi bi-calendar3 me-1 text-primary"></i>
                                                    Pension Year
                                                </label>
                                                <select
                                                    className="form-select"
                                                    value={year}
                                                    onChange={(e) =>
                                                        setYear(e.target.value)
                                                    }
                                                >
                                                    <option value="">
                                                        -- Select Year --
                                                    </option>
                                                    {Array.from(
                                                        {
                                                            length:
                                                                currentYear -
                                                                2020,
                                                        },
                                                        (_, i) => (
                                                            <option
                                                                key={i}
                                                                value={
                                                                    currentYear -
                                                                    i
                                                                }
                                                            >
                                                                {currentYear -
                                                                    i}
                                                            </option>
                                                        )
                                                    )}
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-md-3 d-flex align-items-center">
                                        <div className="w-100 text-center p-4 rounded-3 border bg-white shadow-sm">
                                            <div className="text-muted small mb-1">
                                                Selected Period
                                            </div>
                                            <div
                                                className={`fw-bold fs-5 ${
                                                    isValid
                                                        ? "text-primary"
                                                        : "text-secondary"
                                                }`}
                                            >
                                                {isValid
                                                    ? `${month} ${year}`
                                                    : "—"}
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-md-5 d-flex align-items-center">
                                        <button
                                            type="submit"
                                            className={`btn btn-lg w-100 rounded-3 ${
                                                isValid
                                                    ? "btn-success"
                                                    : "btn-outline-secondary"
                                            }`}
                                            disabled={!isValid}
                                        >
                                            <i className="bi bi-gear-wide-connected me-2"></i>
                                            Generate Pension
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div className="card-footer text-muted small text-center bg-light rounded-bottom-4">
                            Pension will be generated for the selected month and
                            year
                        </div>
                    </div>
                </div>
            </div>
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
