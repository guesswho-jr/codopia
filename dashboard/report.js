const reportBtns = document.querySelectorAll(".report-btn");
reportBtns.forEach(btn => {
    btn.addEventListener("click", e => {
        const projectId = btn.getAttribute("projectId");
        let reportValue = 0;
        let reportText = "None";
        
        function handleConfirm() {
            const formData = new FormData();
            formData.append("projectId", projectId);
            formData.append("reportValue", reportValue);
            formData.append("reportText", reportText);
            fetch("report.php", {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.STATUS_TYPE,
                    title: data.STATUS_TITLE,
                    text: data.STATUS_MESSAGE
                });

                if (data.STATUS_TYPE == "success") {
                    btn.querySelector(".report-count").textContent = Number(btn.querySelector(".report-count").textContent) + 1;
                    btn.querySelector("img").setAttribute("src", "/imgs/exclamation-muted.svg");
                }
            })
            .catch(error => {
                console.log("Error:", error);
            });
        }

        Swal.fire({
            title: "Choose the report subject",
            icon: "warning",
            html: `
                <div class="container report-subject-container">
                    <button class="report-subject btn btn-outline-secondary mb-1 col-12" report-subject-id="1">Embedded Virus</button>
                    <button class="report-subject btn btn-outline-secondary mb-1 col-12" report-subject-id="2">Explicit Content</button>
                    <button class="report-subject btn btn-outline-secondary mb-1 col-12" report-subject-id="3">Improper Name</button>
                    <button class="report-subject btn btn-outline-secondary mb-1 col-12" report-subject-id="4">Copyright Issue</button>
                </div>
            `,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "Report!",
            cancelButtonText: "Cancel",
            preConfirm: handleConfirm
        })

        const reportSubjects = document.querySelectorAll(".report-subject");
        let lastClicked = null;

        reportSubjects.forEach(subject => {
            subject.addEventListener("click", ev => {
                if (lastClicked) {
                    lastClicked.classList.remove("btn-secondary");
                    lastClicked.classList.add("btn-outline-secondary");
                    subject.classList.add("btn-secondary");
                    subject.classList.remove("btn-outline-secondary");
                    reportValue = subject.getAttribute("report-subject-id");
                    reportText = subject.textContent;
                } else {
                    subject.classList.add("btn-secondary");
                    subject.classList.remove("btn-outline-secondary");
                    reportValue = subject.getAttribute("report-subject-id");
                    reportText = subject.textContent;
                }
                lastClicked = subject;
            });
        });
        // const formData = new FormData();
        // formData.append("projectId", btn.getAttribute("projectId"));

        // fetch("report.php", {
        //     method: "POST",
        //     body: formData
        // }).then(response => response.json())
        // .then(data => console.log(data))
        // .catch(error => console.log(error));
        // console.log(btn)
    });
});

