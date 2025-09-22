document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".selectable-row").forEach((row) => {
        row.addEventListener("click", (e) => {
            let selectedOfficeCode = e.currentTarget.getAttribute("data-value");
            let selectedOfficename = e.currentTarget.getAttribute("data-name");
            const officeField = document.getElementById("office");
            const officeID = document.getElementById("office_id");
            officeField.value = selectedOfficename;
            officeID.value = selectedOfficeCode;

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
                console.log(parseInt(index));
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
                    window.location.href = response.redirected;
                } else {
                }
            });

            let modalElement = document.getElementById(
                "pensionerDeleteActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });
});
