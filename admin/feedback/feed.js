const modal = document.querySelectorAll(".g-modal");

const openBtn = document.querySelectorAll('.g-open');
const closeBtn = document.querySelectorAll('.g-close');

for (let i = 0; i < modal.length; i++) {
  openBtn[i].addEventListener('click', () => {
    modal[i].style.display = "block";
  })

  closeBtn[i].addEventListener('click', () => {
    modal[i].style.display = "none";
  })

  window.addEventListener("click", function (event) {
    if (event.target == modal[i]) {
      modal[i].style.display = "none";
    }
  });
}

const searchInput = document.getElementById("searchInput").value.toLowerCase();
const elements = document.querySelectorAll(".inputData");

searchInput.addEventListener("keyup", function (event) {


  elements.forEach(element => {
    // console.log(element.textContent.toLowerCase().includes(event.key), element);

    if (element.textContent.toLowerCase().includes(searchInput)) {
      element.parentElement.style.display = 'table-row';

    }

    else if (!element.textContent.toLowerCase().includes(searchInput)) {
      element.parentElement.style.display = "none";
    }



  });
});