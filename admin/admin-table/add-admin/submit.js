const formEl = document.getElementById("form"); // the element

formEl.addEventListener("submit", async e=>{
    e.preventDefault();
    let formData = new FormData(formEl);
    let responseFirst = await fetch("submit.php", {
        method: "POST",
        body: formData
    })
    let jsonResponse = responseFirst.json();
    let realData = await jsonResponse;
    if (realData.type==='success') alert("Success");
    else {
        alert(`Error ${realData.error}`);
    }
})