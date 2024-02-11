/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Get the modal
var modal = document.getElementById("myModal");

// // Get the button that opens the modal
 var btn = document.getElementById("myBtn");

// // Get the <span> element that closes the modal
 var span = document.getElementsByClassName("close")[0];


  btn.onclick = function() {

 
    modal.style.display = "block";
  }
 
 

 // When the user clicks on <span> (x), close the modal


  span.onclick = function() {
    modal.style.display = "none";
 }
 


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


  




