// const uploadForm = document.getElementById("upload-form");
// const theFile = document.querySelector("#file-upload");

// uploadForm.addEventListener("submit", async event=>{
//     event.preventDefault();
//     let formData = new FormData(uploadForm);
//     formData.append("theFile", theFile.files[0]);
//     console.log(formData.get("theFile"))
//     let resp = await fetch("upload.php", {
//         method: "POST",
//         body: formData
//     });
//     let response = await resp.json();
//     console.log(response);
// })