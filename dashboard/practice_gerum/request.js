document.addEventListener("DOMContentLoaded", () => {

    const likers = document.querySelectorAll('.liker');
    likers.forEach(btn => {
        btn.addEventListener("click", event => {
            const target = event.target;
            const postData = JSON.stringify({
                post_id: target.getAttribute("post_id")
            });

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process.php", true);
            xhr.onload = function() {
                console.log(xhr.response);
                if (xhr.response == "LIKED") {
                    target.classList.add("liked");
                    target.classList.remove("unliked");
                }
                else if (xhr.response == "UNLIKED") {
                    target.classList.add("unliked");
                    target.classList.remove("liked");
                }
            }
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(postData);
        });
    });

});