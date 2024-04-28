document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("feedback-form");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const feed = document.querySelector(".codo-feed").value;
        const bug = document.querySelector(".codo-bug").checked ? 1 : 0;
        let rate = document.getElementById("starValue").value;
        rate = rate ? rate : 0;

        const formData = new FormData();

        formData.append("feed", feed);
        formData.append("bug", bug);
        formData.append("rate", rate);

        // // Log the contents of formData
        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + ', ' + pair[1]);
        // }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./feedHandler.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                const response = JSON.parse(xhr.response);
                if (response.ERROR_CODE) {
                    Swal.fire({
                        icon: "error",
                        title: `ERROR: ${response.ERROR_CODE}`,
                        text: response.ERROR_MESSAGE,
                        // footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Feedback Sent!",
                    });
                    form.reset();
                }
            }
        }
        xhr.send(formData);

    });

});