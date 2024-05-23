const commentOpener = document.querySelectorAll(".comment-opener");

// ADD NEW COMMENT

function addNewComment(currentOpen, commentSubmit) {
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
                        const day = dataObject.getDate();
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
                                        <img src='../imgs/heart-muted.svg' class='comment-like-btn' commentId=${objData.data.commentId} width='25' height='25' style='cursor: pointer'>
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
                        currentOpen.querySelector(".comment-count").textContent = Number(currentOpen.querySelector(".comment-count").textContent) + 1;
                        likeSystem();
                        break;
                    case "not done":
                        console.error("not done!")
                        break;
                    case "commento":
                        Swal.fire({
                            // title: "The Internet?",
                            icon: "error",
                            text: objData.text
                        });
                        break;
                    default:
                        console.error("Could not send comment!")
                }
            }
        }
        xhr.send(formData);
    }
    document.getElementById("my-comment").value = "";
}

// ABOUT WHICH COMMENT SHOULD BE DISPLAYED ON THE COMMENT BAR WHEN THE COMMENT BUTTON IS CLICKED

commentOpener.forEach(opener => {
    opener.addEventListener("click", event => {
        const commentSubmit = document.getElementById("comment-submit");
        const commentContainer = document.getElementById("comment-container");

        const formData = new FormData();
        formData.append("projectId", opener.getAttribute("projectId"));
        commentSubmit.setAttribute("projectId", opener.getAttribute("projectId"));

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./comment.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                const grandData = JSON.parse(xhr.response)
                console.log(grandData);
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
                            // console.log(data);
                            const timestampMilli = Number(data.comment_time) * 1000;
                            const dataObject = new Date(timestampMilli);
                            const month = dataObject.toLocaleString("default", { month: "short" });
                            const day = dataObject.getDate();
                            const year = dataObject.getFullYear();
                            const formattedDate = `${month} ${day}, ${year}`;

                            const commentLikedBy = JSON.parse(data.comment_liked_by);
                            const userid = grandData.userid;
                            let heartIcon = commentLikedBy.includes(userid) ? "heart.svg" : "heart-muted.svg";

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
                                        <img src='../imgs/${heartIcon}' class='comment-like-btn' commentId=${data.comment_id} width='25' height='25' style='cursor: pointer'>
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

                // OPTIMIZE: COMMENT ADD SYSTEM
                commentSubmit.addEventListener("click", function () {
                    addNewComment(opener, commentSubmit);
                });
                document.getElementById("my-comment").addEventListener("keyup", event => {
                    if (event.key === "Enter" && document.getElementById("my-comment").value != "") {
                        event.preventDefault();
                        addNewComment(opener, commentSubmit);
                        document.getElementById("my-comment").value = "";
                    }
                });

                // COMMENT LIKE SYSTEM
                likeSystem();
            }
        }
        xhr.send(formData);
    }, { capture: true });
});

function likeSystem() {
    const likeBtns = document.querySelectorAll(".comment-like-btn");
    likeBtns.forEach(btn => {
        if (!btn.classList.contains("like-event-attached")) {
            btn.classList.add("like-event-attached");
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
                                btn.setAttribute("src", "../imgs/heart.svg");
                                btn.nextElementSibling.textContent = Number(btn.nextElementSibling.textContent) + 1;
                                break;
                            case "disliked":
                                btn.setAttribute("src", "../imgs/heart-muted.svg");
                                btn.nextElementSibling.textContent = Number(btn.nextElementSibling.textContent) - 1;
                                break;
                            default:
                                console.error("Error occurred when trying to like or dislike!");
                        }
                    }
                }
                xhr.send(formData);
            }, { capture: true });
        }
    });
}