const deleteBtns = document.querySelectorAll(".delete-btn");

deleteBtns.forEach(btn => {
    btn.addEventListener("click", event => {
        const targetBtn = event.target;
        const projectId = targetBtn.getAttribute("projectId"); 
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                switch (xhr.response) {
                    case "ERROR":
                        Swal.fire({
                            title: "ERROR!",
                            text: "Could not delete project!",
                            icon: "warning"
                        });
                        break;
                    default:
                        document.getElementById("project_table").children[1].removeChild(targetBtn.parentElement.parentElement);
                }
            }
        }
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(projectId);
    })
})