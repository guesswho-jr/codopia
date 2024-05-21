const no = document.getElementById("number");
const form = document.getElementById("form");
const questions = document.getElementById("questions");
const basicData = `
    <div class="question bg-light shadow p-3">
        <input type="text" class="form-control mt-4" placeholder="Question" required>
        <input type="text" class="form-control mt-1" placeholder="First choice (a)" required>
        <input type="text" class="form-control mt-1" placeholder="Second choice (b)" required>
        <input type="text" class="form-control mt-1" placeholder="Third choice (c)" required>
        <input type="text" class="form-control mt-1" placeholder="Fourth choice (d)" required>
        <input type="text" class="form-control mt-1" placeholder="Answer" required>
    </div>
`;

const questionMother = document.createElement("div");

no.addEventListener("keyup", () => {
    const key = Number(no.value);
    finalData = ''; // Clear previous questions

    if (key > 0) {
        for (let index = 0; index < key; index++) {
            finalData += basicData;
        }
        questionMother.innerHTML = finalData + `
            <div class="container p-1">
                <input type='submit' value='Submit' class="btn btn-primary col-12 mt-2">
            </div>`;
    } else {
        questionMother.innerHTML = ''; // Clear the submit button if input is cleared
    }

    questions.innerHTML = ''; // Clear previous questions
    questions.appendChild(questionMother);
});

form.addEventListener("submit", e => {
    e.preventDefault();
    const subject = document.querySelector("input[name='subject']").value;
    const diff = document.querySelector("select[name='diff']").value;
    if (subject && diff) {
        let dataToSend = {};
        let i = 0;
        const questionElements = document.querySelectorAll(".question");
        questionElements.forEach(Question => {
            dataToSend[`Question_${i}`] = {
                question: Question.children[0].value,
                a: Question.children[1].value,
                b: Question.children[2].value,
                c: Question.children[3].value,
                d: Question.children[4].value,
                answer: Question.children[5].value
            };
            i++;
        });
    
        const formData = new FormData();
        formData.append("data", JSON.stringify(dataToSend));
        formData.append("subject", subject);
        formData.append("diff", diff);
        fetch("./uploader.php", {
            method: "post",
            body: formData
        }).then(response => response.json()).then(data => {
            console.log(data); // Handle response data
        }).catch(error => {
            console.error("Error:", error); // Handle errors
        });
    } else {
        console.log("Please fill in all necessary fields properly")
    }
});
