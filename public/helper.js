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
            let index = e.currentTarget.getAttribute("data-index");
            const deleteButton = document.getElementById(
                "pensionerDeleteButton"
            );
            console.log(index);

            const span = document.getElementById(
                "pensionerDeleteActionModalSpan"
            );
            span.innerText = index;
            let modalElement = document.getElementById(
                "pensionerDeleteActionModal"
            );
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });
});
