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
                const response = await fetch(`/api/pensioner/delete/`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: index + 1 }),
                });
                if (response.redirected) {
                    console.log("done");
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
