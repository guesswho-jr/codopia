// ADD NEW COMMENT

const commentSubmit = document.getElementById("comment-submit");

commentSubmit.addEventListener("click", event => {
    const myComment = document.getElementById("my-comment").value;
    const commentContainer = document.getElementById("comment-container");
    if (myComment) {
        const formData = new FormData();
        formData.append("myComment", myComment);
        formData.append("submitProjectId", commentSubmit.getAttribute("projectId"));
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./comment.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                const objData = JSON.parse(xhr.response);
                switch (objData.status) {
                    case "done":
                        const timestampMilli = Number(objData.data.time) * 1000;
                        const dataObject = new Date(timestampMilli);
                        const month = dataObject.toLocaleString("default", { month: "short" });
                        const day = dataObject.getDay();
                        const year = dataObject.getFullYear();
                        const formattedDate = `${month} ${day}, ${year}`;

                        const justSentComment = document.createElement("div");
                        justSentComment.setAttribute("class", "container");
                        justSentComment.innerHTML = `
                            <div class='container my-3 p-3 border border-2 border-muted shadow-sm bg-light'>
                                <div class='col-12'>
                                    <span class='bg-dark text-white col-3' style='width: 30px; height: 30px; display: inline-flex; justify-content: center; align-items: center; border-radius: 50%;'>${objData.data.username[0].toUpperCase()}</span>
                                    <a href='' class='text-dark fw-bold col-9' style='text-decoration: none;'>@${objData.data.username}</a>
                                </div>
                                <div class='col-12'>
                                    <p class='m-0'>${objData.data.text}</p>
                                    <div class='d-flex justify-content-between'>
                                    <div class='text-center'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-suit-heart comment-like-btn' commentId='${objData.data.commentId}' viewBox='0 0 16 16' style='cursor: pointer'>
                                            <path d='m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.6 7.6 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z' />
                                        </svg>
                                        <span class='small ms-1'>${0}</span>
                                    </div>
                                    <span class='text-muted d-flex flex-column justify-content-end small'>${formattedDate}</span>
                                    </div>
                                </div>
                            </div>
                            `;
                        if (document.getElementById("no-comment-so-far")) {
                            document.getElementById("no-comment-so-far").remove();
                        }
                        commentContainer.insertBefore(justSentComment, commentContainer.firstChild);
                        document.getElementById("my-comment").value = "";
                        break;
                    case "not done":
                        console.error("not done!")
                        break;
                    default:
                        console.error("Could not send comment!")
                }
                // FIX: ADD LIKE SYSTEM HERE
                // likeDislike();
            }
        }
        xhr.send(formData);
    }
});

// ABOUT WHICH COMMENT SHOULD BE DISPLAYED ON THE COMMENT BAR WHEN THE COMMENT BUTTON IS CLICKED

const commentOpener = document.querySelectorAll(".comment-opener");

commentOpener.forEach(opener => {
    opener.addEventListener("click", event => {
        const commentContainer = document.getElementById("comment-container");

        const formData = new FormData();
        formData.append("projectId", opener.getAttribute("projectId"));
        commentSubmit.setAttribute("projectId", opener.getAttribute("projectId"));

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./comment.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                const grandData = JSON.parse(xhr.response)
                switch (grandData.status) {
                    case "no":
                        commentContainer.innerHTML = "";
                        const noComment = document.createElement("div");
                        noComment.setAttribute("class", "container");
                        noComment.innerHTML = `
                        <div class='container my-3 p-3 text-center'>
                            <div class='col-12'>
                                <h4 class='m-0' id='no-comment-so-far'>${grandData.text}</h4>
                            </div>
                        </div>
                        `;
                        commentContainer.appendChild(noComment);
                        break;
                    case "yes":
                        commentContainer.innerHTML = "";
                        for (let data of grandData.text) {
                            const timestampMilli = Number(data.comment_time) * 1000;
                            const dataObject = new Date(timestampMilli);
                            const month = dataObject.toLocaleString("default", { month: "short" });
                            const day = dataObject.getDay();
                            const year = dataObject.getFullYear();
                            const formattedDate = `${month} ${day}, ${year}`;

                            const newComment = document.createElement("div");
                            newComment.setAttribute("class", "container");
                            newComment.innerHTML = `
                            <div class='container my-3 p-3 border border-2 border-muted shadow-sm bg-light'>
                                <div class='col-12'>
                                    <span class='bg-dark text-white col-3' style='width: 30px; height: 30px; display: inline-flex; justify-content: center; align-items: center; border-radius: 50%;'>${data.username[0].toUpperCase()}</span>
                                    <a href='' class='text-dark fw-bold col-9' style='text-decoration: none;'>@${data.username}</a>
                                </div>
                                <div class='col-12'>
                                    <p class='m-0'>${data.comment_text}</p>
                                    <div class='d-flex justify-content-between'>
                                    <div class='text-center'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-suit-heart comment-like-btn' commentId=${data.comment_id} viewBox='0 0 16 16' style='cursor: pointer'>
                                            <path d='m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.6 7.6 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z' />
                                        </svg>
                                        <span class='small'>${data.comment_likes}</span>
                                    </div>
                                    <span class='text-muted d-flex flex-column justify-content-end small'>${formattedDate}</span>
                                    </div>
                                </div>
                            </div>
                            `;
                            commentContainer.appendChild(newComment);
                        }
                        break;
                    default:
                        console.error("Could not receive response!");
                }

                // COMMENT LIKE SYSTEM

                const likeBtns = document.querySelectorAll(".comment-like-btn");
                likeBtns.forEach(btn => {
                    btn.addEventListener("click", function (event) {
                        const commentId = event.target.getAttribute("commentid");
                        const formData = new FormData();
                        formData.append("commentId", commentId);

                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "./comment.php", true);
                        xhr.onload = function () {
                            if (xhr.status == 200) {
                                const likeData = JSON.parse(xhr.response);
                                switch (likeData.status) {
                                    case "liked":
                                        btn.nextElementSibling.textContent = Number(btn.nextElementSibling.textContent) + 1;
                                        break;
                                    case "disliked":
                                        btn.nextElementSibling.textContent = Number(btn.nextElementSibling.textContent) - 1;
                                        break;
                                    default:
                                        console.error("Error occurred when trying to like or dislike!");
                                }
                            }
                        }
                        xhr.send(formData);
                    }, { capture: true });
                });
            }
        }
        xhr.send(formData);
    });
});