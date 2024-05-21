const form = document.getElementById("editForm");

form.addEventListener("submit", event => {
    event.preventDefault();
    const formData = new FormData(form);
    fetch("./editHandler.php", {
        method: "POST",
        body: formData
    })
    .then(resp => resp.json())
    .then(data => {
        Swal.fire({
            icon: data.type,
            text: data.text,
        });
    })
    .catch(err => { console.log(err) });
})