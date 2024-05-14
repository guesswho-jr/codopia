const form = document.getElementById("up-form");

document.getElementById("username").addEventListener("blur", () => {
    let form = new FormData();
    form.append("type", 99);
    form.append("username", document.getElementById("username").value)
    fetch("submit.php", {
      method: "CHECK",
      body: form
    }).then(resp => resp.json())
      .then(data => {
        if (data.success) {
          document.getElementById("information").textContent = data.success; document.getElementById("information").style.color = "green"
        }
        else if (data.error) document.querySelector(".message").textContent = data.error
        else if (data.info) {
          document.getElementById("information").textContent = data.info;
          document.getElementById("information").style.color = "red"
        }
      })
  });
form.addEventListener("submit", e => {
    e.preventDefault();

    const fname = document.getElementById("full_name").value;
    const email = document.getElementById("email").value;
    const username = document.getElementById("username").value;
    const password = document.getElementById("pass").value;
    const confirm = document.getElementById("cpass").value;
    const bio = document.getElementById("textarea").value;
    const checkbox = document.getElementById("flexCheckChecked").checked ? 1 : 0;

    const formData = new FormData();
    formData.append("fname", fname);
    formData.append("email", email);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("confirm", confirm);
    formData.append("bio", bio);
    formData.append("checkbox", checkbox);
		
    // for (let [key, value] of formData.entries()) {
    //     console.log(`${key}: ${value}`);
    // }

    const xhr_mail = new XMLHttpRequest();
    xhr_mail.open("POST", "./mail.php", true);
    xhr_mail.onload = function() {
        if (xhr_mail.status == 200) {
            const response_mail = JSON.parse(xhr_mail.response);
            if (response_mail.STATUS_CODE == "001") {
                Swal.fire({
                    title: "Email Verification",
                    text: "Enter the verification code sent to your email",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Verify",
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const inputCode = document.getElementById("swal2-input").value;
                        if (inputCode) {
                            formData.append("code", inputCode);
                            // OPTIMIZE: SECOND REQUEST
                            const xhr_verify = new XMLHttpRequest();
                            xhr_verify.open('POST', './verify.php', true);
                            xhr_verify.onload = function () {
                                if (xhr_verify.status === 200) {
                                    const response_verify = JSON.parse(xhr_verify.response);
                                    if (response_verify.type == "success") {
                                        window.location.href = "../login/";
                                    }
                                    else if (response_verify.type == "error") {
                                        Swal.fire({
                                            text: response_verify.message,
                                            icon: "error"
                                        });
                                    }

                                }
                            };
                            xhr_verify.onerror = function () {
                                // What to do when the request fails
                            };
                            xhr_verify.send(formData);
                        } else {
                            Swal.fire({
                                title: "Empty input!",
                                icon: "error"
                            });
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            } else {
                Swal.fire({
                    title: response_mail.STATUS_TITLE,
                    text: response_mail.STATUS_TEXT,
                    icon: "error"
                });
            }
        }
    }
    xhr_mail.send(formData);

});