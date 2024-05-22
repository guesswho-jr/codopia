const N_reads = document.querySelectorAll(".notification-read-more");

const NM_title = document.querySelector(".notification-modal-title");
const NM_message = document.getElementById("notification-modal-message");

N_reads.forEach(N_read => {
    N_read.addEventListener("click", event => {
        const notifyId = N_read.getAttribute("notifyId");
        const formData = new FormData();
        formData.append("notifyId", notifyId);
        fetch("./notify_modal.php", {
            method: "POST",
            body: formData,
        })
            .then(resp => resp.json())
            .then(data => {
                const parsedText = JSON.parse(data.text);
                // const type = data.type;
                const username = data.username;
                const title = parsedText.title;
                const message = parsedText.message.replace("%USER%", `@${username}`);

                NM_title.textContent = title;
                NM_message.textContent = message;
            })
            .catch(err => {
                console.log("Unexpected error:", err);
            });
    }, { capture: true });
});
