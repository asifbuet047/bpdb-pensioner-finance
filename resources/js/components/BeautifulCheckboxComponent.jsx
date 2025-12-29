import React from "react";

export default function BeautifulCheckboxComponent({
    id,
    label,
    description,
    checked,
    onChange,
    religion = "Islam",
    disabled = false,
    error = false,
}) {
    return (
        <div className="form-check p-3 rounded-3 border border-2 shadow-sm bg-white">
            <input
                className={`form-check-input ${error ? "is-invalid" : ""}`}
                type="checkbox"
                id={id}
                checked={checked}
                onChange={(e) => onChange(e.target.checked)}
                disabled={disabled}
            />

            <label className="form-check-label fw-semibold ms-2" htmlFor={id}>
                {label}
            </label>

            {description && (
                <div className="text-muted small mt-1 ms-4">
                    {description}{" "}
                    <span className="fw-bold">{religion} pensioners</span>
                </div>
            )}

            {error && (
                <div className="invalid-feedback d-block mt-1 ms-4">
                    This field is required
                </div>
            )}
        </div>
    );
}
