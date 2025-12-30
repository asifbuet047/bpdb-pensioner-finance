import axios from "axios";
import { useRef, useState } from "react";
import { Snackbar, Alert } from "@mui/material";
import { createPortal } from "react-dom";
import BeautifulCheckboxComponent from "./BeautifulCheckboxComponent";

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
    const currentYear = new Date().getFullYear();

    const [month, setMonth] = useState(currentMonth);
    const [year, setYear] = useState(currentYear);

    const [snackbarOpen, setSnackbarOpen] = useState(false);
    const [snackbarMessage, setSnackbarMessage] = useState("");
    const [snackbarSeverity, setSnackbarSeverity] = useState("error");
    const [onlybonus, setOnlybonus] = useState(false);

    const [actions, setActions] = useState({
        muslim_bonus: false,
        hindu_bonus: false,
        christian_bonus: false,
        buddhist_bonus: false,
        bangla_new_year_bonus: false,
    });

    const modalInstance = useRef(null);

    const setModalRef = (node) => {
        if (node && !modalInstance.current && window.bootstrap) {
            modalInstance.current = new window.bootstrap.Modal(node);
        }
    };

    const openModal = (message) => {
        modalInstance.current?.show();
        if (message === "generate_bonus") {
            setOnlybonus(true);
        } else {
            setOnlybonus(false);
        }
    };
    const closeModal = () => {
        modalInstance.current?.hide();
    };

    const toggleBonus = (key) => {
        const temp = { ...actions };
        temp[key] = !temp[key];
        setActions(temp);
    };

    const handleSubmit = async () => {
        closeModal();

        // Early validation
        if (onlybonus && !Object.values(actions).some(Boolean)) {
            setSnackbarMessage("Please select at least one bonus");
            setSnackbarSeverity("error");
            setSnackbarOpen(true);
            return;
        }

        try {
            const { data } = await axios.get("/api/pensioners/approved", {
                withCredentials: true,
            });

            if (!data?.success) {
                window.location.href = "/";
                return;
            }

            setSnackbarMessage(data.message || "Success");
            setSnackbarSeverity("success");
            setSnackbarOpen(true);

            const params = new URLSearchParams({
                month,
                year,
                onlybonus,
                ...actions,
            });

            window.location.href = `/view/pensioners/approved?${params.toString()}`;
        } catch (error) {
            setSnackbarMessage(
                error?.response?.data?.message || "Something went wrong"
            );
            setSnackbarSeverity("error");
            setSnackbarOpen(true);
        }
    };

    const isValid = month && year;

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
                                                {months.map((m) => (
                                                    <option key={m} value={m}>
                                                        {m}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>

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
                                            {Array.from(
                                                {
                                                    length:
                                                        currentYear - 2020 + 1,
                                                },
                                                (_, i) => (
                                                    <option
                                                        key={i}
                                                        value={currentYear - i}
                                                    >
                                                        {currentYear - i}
                                                    </option>
                                                )
                                            )}
                                        </select>
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
                                            {isValid ? `${month} ${year}` : "—"}
                                        </div>
                                    </div>
                                </div>

                                <div className="col-md-5 d-flex flex-column gap-2 align-items-center justify-content-center">
                                    <button
                                        className={`btn btn-lg w-100 rounded-3 ${
                                            isValid
                                                ? "btn-success"
                                                : "btn-outline-secondary"
                                        }`}
                                        disabled={!isValid}
                                        onClick={() =>
                                            openModal("generate_pension")
                                        }
                                    >
                                        <i className="bi bi-gear-wide-connected me-2"></i>
                                        Generate Pension
                                    </button>

                                    <button
                                        className={`btn btn-lg w-100 rounded-3 ${
                                            isValid
                                                ? "btn-success"
                                                : "btn-outline-secondary"
                                        }`}
                                        disabled={!isValid}
                                        onClick={() =>
                                            openModal("generate_bonus")
                                        }
                                    >
                                        <i className="bi bi-gift me-2"></i>
                                        Generate Bonus Only
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="card-footer text-muted small text-center bg-light rounded-bottom-4">
                            Pension will be generated for the selected month and
                            year
                        </div>
                    </div>
                </div>
            </div>

            {createPortal(
                <div
                    className="modal fade"
                    ref={setModalRef}
                    tabIndex="-1"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header bg-primary text-white">
                                <h5 className="modal-title d-flex align-items-center">
                                    <i className="bi bi-shield-check me-2"></i>
                                    Approval Confirmation
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close btn-close-white"
                                    onClick={closeModal}
                                ></button>
                            </div>

                            <div className="modal-body px-4 py-3">
                                <p className="text-muted small mb-3">
                                    Please select what you want to generate for
                                    <strong>
                                        {" "}
                                        {month} {year}
                                    </strong>
                                    .
                                </p>

                                <div className="d-flex flex-column gap-3">
                                    <BeautifulCheckboxComponent
                                        id="generate"
                                        label="EId Bonus"
                                        description="Include Eid-Ul-Fiter or Eid-Ul-Azha bonus for"
                                        religion="Muslim"
                                        checked={actions.muslim_bonus}
                                        onChange={() =>
                                            toggleBonus("muslim_bonus")
                                        }
                                    />

                                    <BeautifulCheckboxComponent
                                        id="witBonus"
                                        label="Puja Bonus"
                                        description="Include Durga Puja bonus for"
                                        religion="Hindu"
                                        checked={actions.hindu_bonus}
                                        onChange={() =>
                                            toggleBonus("hindu_bonus")
                                        }
                                    />
                                    <BeautifulCheckboxComponent
                                        id="witBonus"
                                        label="Chrismas Bonus"
                                        description="Include Chrismas bonus for"
                                        religion="Christian"
                                        checked={actions.christian_bonus}
                                        onChange={() =>
                                            toggleBonus("christian_bonus")
                                        }
                                    />
                                    <BeautifulCheckboxComponent
                                        id="witBonus"
                                        label="Boddho Purnima Bonus"
                                        description="Include Boddho Purnima bonus for"
                                        religion="Budddist"
                                        checked={actions.buddhist_bonus}
                                        onChange={() =>
                                            toggleBonus("buddhist_bonus")
                                        }
                                    />

                                    <BeautifulCheckboxComponent
                                        id="bonus"
                                        label="Bangla New Year Bonus"
                                        description="Include Bangla New Year bonus for"
                                        religion="All"
                                        checked={actions.bangla_new_year_bonus}
                                        onChange={() =>
                                            toggleBonus("bangla_new_year_bonus")
                                        }
                                    />
                                </div>

                                <div className="alert alert-warning d-flex align-items-center mt-4 small">
                                    <i className="bi bi-check2-square me-2"></i>
                                    Multiple selection is permissible
                                </div>
                            </div>

                            <div className="modal-footer">
                                <button
                                    className="btn btn-outline-secondary"
                                    onClick={closeModal}
                                >
                                    Cancel
                                </button>

                                <button
                                    className="btn btn-success px-4"
                                    onClick={handleSubmit}
                                >
                                    <i className="bi bi-check-circle me-1"></i>
                                    Yes, Generate
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
        </div>
    );
}
