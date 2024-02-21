
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
// Get the modal
var modalComm = document.getElementById("myModalComm");

// Get the button that opens the modal
var btnComm = document.querySelectorAll("#myBtnCommentaire");

// Get the <span> element that closes the modal
var spanComm = document.getElementsByClassName("closeComm")[0];

// When the user clicks the button, open the modal 
// Supposons que btnComm est un tableau contenant des références à des boutons

for (let i = 0; i < btnComm.length; i++) {
  btnComm[i].onclick = function() {
    let parentNode = this.parentElement.getAttribute('id');
    console.log(parentNode);
    modalComm.style.display = "block";
    const selectElement = document.getElementById('commentaire_article');

    while (selectElement.firstChild) {
        selectElement.removeChild(selectElement.firstChild);
    }
    let option = document.createElement('option');  
    option.value = parentNode;
    selectElement.appendChild(option);
    selectElement.style.display = "none";
    
  }
}



// When the user clicks on <span> (x), close the modal
spanComm.onclick = function() {
  modalComm.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modalComm) {
    modalComm.style.display = "none";
  }
}