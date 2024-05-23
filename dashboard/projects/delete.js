const deleteBtns = document.querySelectorAll(".delete-btn");
let isDeleted = false;

deleteBtns.forEach(btn => {
    btn.addEventListener("click", event => {
        const targetBtn = event.target;
        const projectId = targetBtn.getAttribute("projectId");
        const pui = targetBtn.getAttribute("projectUniqueIdentifier");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, do it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve, reject) => {
                    // const formData = new FormData();
                    // formData.append("projectId", projectId);
                    // formData.append("pui", pui);
                    const dataToSend = JSON.stringify({
                        projectId: projectId,
                        pui: pui
                    });

                    fetch("./delete.php", {
                        method: "POST",
                        body: dataToSend
                    })
                    .then(resp => resp.json())
                    .then(data => {
                        resolve(data);
                        Swal.fire({
                            // title: `${response.TYPE}: ${response.CODE}`,
                            text: data.MESSAGE,
                            icon: data.TYPE
                        });
                        if (data.CODE == 2001) {
                            isDeleted = true;
                            document.getElementById("project_table").children[1].removeChild(targetBtn.parentElement.parentElement);
                        }
                    })
                    .catch(err => {
                        reject('Something went wrong:', err);
                    });
                    // const xhr = new XMLHttpRequest();
                    // xhr.open('POST', './delete.php', true);
                    // xhr.onload = function () {
                    //     if (xhr.status === 200) {
                    //         const response = JSON.parse(xhr.responseText);
                    //         resolve(response);
                    //         // let codeOnSwalTitle = response.TYPE == "success" ? "" : response.TYPE.toUpperCase();
                    //         Swal.fire({
                    //             // title: `${response.TYPE}: ${response.CODE}`,
                    //             text: response.MESSAGE,
                    //             icon: response.TYPE
                    //         });
                    //         if (response.CODE == 2001) isDeleted = true;
                    //         document.getElementById("project_table").children[1].removeChild(targetBtn.parentElement.parentElement);
                    //     } else {
                    //         reject('Something went wrong!');
                    //     }
                    // };

                    // xhr.onerror = function () {
                    //     reject('Something went wrong!');
                    // };

                    // xhr.send(formData);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && isDeleted) {
                Swal.fire({
                    title: "Deleting project...",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                })
            }
        });
    });
});