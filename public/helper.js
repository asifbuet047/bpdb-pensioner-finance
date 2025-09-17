document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".selectable-row").forEach((row) => {
        row.addEventListener("click", (e) => {
            let selectedOfficeCode = e.currentTarget.getAttribute("data-value");
            let selectedOfficename = e.currentTarget.getAttribute("data-name");
            const officeField = document.getElementById("office");
            const officeID = document.getElementById("office_id");
            officeField.value = selectedOfficename;
            officeID.value = selectedOfficeCode;
            console.log(officeID.value);

            let modalElement = document.getElementById("selectModal");
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    });
});
