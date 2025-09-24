document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".selectable-row").forEach((row) => {
        row.addEventListener("click", (e) => {
            let selectedOfficeCode = e.currentTarget.getAttribute("data-value");
            let selectedOfficename = e.currentTarget.getAttribute("data-name");
            const officeField = document.getElementById("office");
            const officeID = document.getElementById("office_id");
            officeField.value = selectedOfficename;
            officeID.value = selectedOfficeCode;
            console.log(
                `office name ${selectedOfficename} and id is ${selectedOfficeCode}`
            );

            let modalElement = document.getElementById("selectModal");
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });

    document.querySelectorAll(".pensioner-delete-buttons").forEach((row) => {
        row.addEventListener("click", (e) => {
            let name = e.currentTarget.getAttribute("data-name");
            let index = e.currentTarget.getAttribute("data-index");
            const span = document.getElementById(
                "pensionerDeleteActionModalSpan"
            );
            span.innerText = name;
            const deleteButton = document.getElementById(
                "pensionerDeleteButton"
            );
            deleteButton.addEventListener("click", async () => {
                const response = await fetch(`/pensioner/remove`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ id: parseInt(index) }),
                });
                if (response.redirected) {
                    window.location.href = "/pensioners/all";
                }
            });

            let modalElement = document.getElementById(
                "pensionerDeleteActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });

    document.querySelectorAll(".pensioner-update-buttons").forEach((row) => {
        row.addEventListener("click", (e) => {
            let name = e.currentTarget.getAttribute("data-name");
            let index = e.currentTarget.getAttribute("data-index");
            const span = document.getElementById(
                "pensionerUpdateActionModalSpan"
            );
            span.innerText = name;
            const updateButton = document.getElementById(
                "pensionerUpdateButton"
            );
            updateButton.addEventListener("click", async () => {
                window.location.href = `/pensioner/update/${index}`;
            });

            let modalElement = document.getElementById(
                "pensionerUpdateActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });

    document.querySelectorAll(".officer-delete-buttons").forEach((row) => {
        row.addEventListener("click", (e) => {
            let name = e.currentTarget.getAttribute("data-name");
            let index = e.currentTarget.getAttribute("data-index");
            const span = document.getElementById(
                "officerDeleteActionModalSpan"
            );
            span.innerText = name;
            const deleteButton = document.getElementById("officerDeleteButton");
            deleteButton.addEventListener("click", async () => {
                const response = await fetch(`/officer/remove`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ id: parseInt(index) }),
                });
                if (response.redirected) {
                    window.location.href = "/officers";
                }
            });

            let modalElement = document.getElementById(
                "officerDeleteActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });

    document.querySelectorAll(".officer-update-buttons").forEach((row) => {
        row.addEventListener("click", (e) => {
            let name = e.currentTarget.getAttribute("data-name");
            let index = e.currentTarget.getAttribute("data-index");
            const span = document.getElementById(
                "officerUpdateActionModalSpan"
            );
            span.innerText = name;
            const updateButton = document.getElementById("officerUpdateButton");
            updateButton.addEventListener("click", async () => {
                window.location.href = `/officer/update/${index}`;
            });

            let modalElement = document.getElementById(
                "pensionerUpdateActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });
});
