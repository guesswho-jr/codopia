const form = document.getElementById("notify-form");
form.addEventListener("submit", event => {
    event.preventDefault();

    const users = document.getElementById("users").value.trim().split(/\s*,\s*/);;
    const check = document.querySelector(".check").checked ? 1 : 0;
    const message = document.getElementById("message").value;

    const formData = new FormData();

    if (!users[0] && !check) {
        console.log("Please specify to whom you are sending")
    } else {
        formData.append("users", users);
        formData.append("check", check);
        formData.append("message", message);

        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        fetch("./notify.php", {
            method: "POST",
            body: formData
        })
            .then(resp => resp.json())
            .then(data => { console.log(data) })
            .catch(err => { console.log("Unexpected error occurred:", err) })
    }
})