document.addEventListener("DOMContentLoaded", () => {

    // MARK: LIKE XHR
    const likers = document.querySelectorAll(".liker");
    likers.forEach(btn => {
        btn.addEventListener("click", event => {
            const projectData = JSON.stringify({
                project_id: btn.getAttribute("project_id")
            });

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./likeHandler.php", true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    switch (xhr.response) {
                        case "LIKED":
                            btn.children[2].textContent = Number(btn.children[2].textContent) + 1;
                            btn.children[2].classList.remove("text-dark");
                            btn.children[2].classList.add("text-danger");
                            btn.children[0].setAttribute("src", "/imgs/heart.svg");
                            break;
                        case "UNLIKED":
                            btn.children[2].textContent = Number(btn.children[2].textContent) - 1;
                            btn.children[2].classList.remove("text-danger");
                            btn.children[2].classList.add("text-dark");
                            btn.children[0].setAttribute("src", "/imgs/heart-muted.svg");
                            break;
                    }
                }
            }
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(projectData);
        }, { capture: true });
    });

    // MARK: EVENT XHR
    const form = document.getElementById("event-form");
    const joinBtn = document.querySelector(".join-btn");
    const totalXp = document.getElementById("total-xp");
    const eventXp = document.getElementById("event-xp");

    if (form) {
        form.addEventListener("submit", event => {
            event.preventDefault();
            const checked = document.querySelector(".condition").checked ? 1 : -1;
            const target = event.target;
            const eventData = JSON.stringify({
                condition: checked,
                event_id: target.getAttribute("event_id"),
                xp: target.getAttribute("xp")
            })

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./acceptHandler.php", true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    if (xhr.response == "ACCEPTED") {
                        joinBtn.style.backgroundColor = "#dc3545";
                        joinBtn.textContent = "Reject";
                        totalXp.textContent = Number(totalXp.textContent) + Number(eventXp.textContent);
                    } else if (xhr.response == "REJECTED") {
                        joinBtn.style.backgroundColor = "#0d6efd";
                        joinBtn.textContent = "Join";
                        totalXp.textContent = Number(totalXp.textContent) - Number(eventXp.textContent);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            // footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    }
                }
            }
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(eventData);
        });
    }


});