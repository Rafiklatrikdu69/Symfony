// Get the modal
var modalComm = document.getElementById("myModalComm");

// Get the button that opens the modal
var btnComm = document.getElementById("myBtnCommentaire");

// Get the <span> element that closes the modal
var spanComm = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btnComm.onclick = function() {
  modalComm.style.display = "block";
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