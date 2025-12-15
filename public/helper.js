document.addEventListener("DOMContentLoaded", () => {
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
            console.log(name);
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

    // const input = document.getElementById("officeSearch");
    // const list = document.getElementById("autocompleteList");
    // const office_id = document.getElementById("office_id");
    // let controller;
    // input.addEventListener("input", async function () {
    //     const query = this.value.trim();

    //     list.innerHTML = "";
    //     if (query.length < 2) {
    //         return;
    //     }

    //     if (controller) {
    //         controller.abort();
    //     }
    //     controller = new AbortController();

    //     try {
    //         const res = await fetch(
    //             `/search-offices?q=${encodeURIComponent(query)}`,
    //             {
    //                 signal: controller.signal,
    //             }
    //         );
    //         setTimeout(() => {
    //             controller.abort();
    //         }, 2000);

    //         const data = await res.json();

    //         list.innerHTML = "";

    //         if (data.length === 0) {
    //             list.innerHTML = `<li class="list-group-item">No results found</li>`;
    //             return;
    //         }

    //         data.forEach((item) => {
    //             const li = document.createElement("li");
    //             li.classList.add("list-group-item");
    //             li.textContent = item.name_in_english;
    //             li.style.cursor = "pointer";

    //             li.addEventListener("click", () => {
    //                 input.value = item.name_in_english;
    //                 office_id.value = item.id;
    //                 list.innerHTML = "";
    //             });

    //             list.appendChild(li);
    //             list.classList.add("show");
    //         });
    //     } catch (e) {
    //         if (e.name !== "AbortError") {
    //             console.error(e);
    //         }
    //     }
    // });

    document.addEventListener("click", function (e) {
        if (!input.contains(e.target) && !list.contains(e.target)) {
            list.innerHTML = "";
        }
    });
});
