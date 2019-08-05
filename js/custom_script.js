jQuery.noConflict();
jQuery(document).ready(function($) {
  // alert('Checking....');
   // Code that uses jQuery's $ can follow here.
   jQuery('#myTable').DataTable({
    responsive: true,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
   });
   jQuery('#GroupTable').DataTable({
    responsive: true,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
   });
   jQuery('#SingleTable').DataTable({
    responsive: true,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
   });
});

// Agreement check button
var checker = document.getElementById('agree');
var sendbtn = document.getElementById('submit');
// sendbtn.disabled = true;
sendbtn.disabled = true;
checker.onchange = function() {
  sendbtn.disabled = !this.checked;
};


// document.getElementById('#sendbtn').disabled = true;

// window.onload = function required(){
//   document.getElementById('first_name_error').innerHTML = "*";
//   document.getElementById('last_name_error').innerHTML = "*";
//   document.getElementById('email_error').innerHTML = "*";
//   document.getElementById('password_error').innerHTML = "*";
// }
// if((document.getElementById('first_name_error').innerHTML !== "") ||  (document.getElementById('last_name_error').innerHTML !== "") || (document.getElementById('email_error').innerHTML !== "") || (document.getElementById('password_error').innerHTML !== "") {
//     sendbtn.disabled
// }

// Form validation

function _(x) {
  document.getElementById(x);
  return true;
}

function validate_firstname() {
  // alert('Js available');
  var first_name = document.getElementById('first_name').value;
  if (first_name == ""){
    document.getElementById('first_name_error').innerHTML = "*** This field is required.";
    // alert('Js available');
  } else {
    document.getElementById('first_name_error').innerHTML = "";
  }
}
function validate_lastname() {
  // alert('Js available');
  var last_name = document.getElementById('last_name').value;
  if (last_name == ""){
    document.getElementById('last_name_error').innerHTML = "*** This field is required.";
    // alert('Js available');
  } else {
    document.getElementById('last_name_error').innerHTML = "";
  }
}
function validate_email() {
  // alert('Js available');
  var email = document.getElementById('email').value;
  if (email == ""){
    document.getElementById('email_error').innerHTML = "*** Email is required.";
    // alert('Js available');
  } else {
    document.getElementById('email_error').innerHTML = "";
    sendbtn.disabled = false;
  }
}
function validate_password() {
  // alert('Js available');
  var password = document.getElementById('password').value;
  if (password == ""){
    document.getElementById('password_error').innerHTML = "*** Password is required.";
    // alert('Js available');
  } else {
    document.getElementById('password_error').innerHTML = "";
  }
}
function checkform() {
  var first_name = document.getElementById('first_name').value;
  var last_name = document.getElementById('last_name').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;

  if ((first_name == "") || (last_name == "")|| (email == "") || (password == "")) {
    document.getElementById('form_error').innerHTML = "*** Please, fill the form appropriately.";
    return false;
  } else {
    return true;
  }
}

function checkformMember() {
  var first_name = document.getElementById('first_name').value;
  var last_name = document.getElementById('last_name').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var phone = document.getElementById('phone').value;
  var phone2 = document.getElementById('phone2').value;
  var contact = document.getElementById('contact').value;

  if ((first_name == "") || (last_name == "")|| (phone == "") || (phone2 == "") || (contact == "")) {
    document.getElementById('form_error').innerHTML = "*** Please, fill the form appropriately.";
    return false;
  } else {
    return true;
  }
}


function valMemberOne() {
  // alert('Js available');
  var memberone = document.getElementById('memberone').value;
  if (memberone == ""){
    document.getElementById('memberone_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('memberone_error').innerHTML = "";
  }
}
function valMemberTwo(){
  // alert('Js available');
  var membertwo = document.getElementById('membertwo').value;
  if (membertwo == ""){
    document.getElementById('membertwo_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('membertwo_error').innerHTML = "";
  }
}

function valMemberThree(){
  // alert('Js available');
  var memberthree = document.getElementById('memberthree').value;
  if (memberthree == ""){
    document.getElementById('memberthree_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('memberthree_error').innerHTML = "";
  }
}
function valMemberFour(){
  // alert('Js available');
  var memberfour = document.getElementById('memberfour').value;
  if (memberfour == ""){
    document.getElementById('memberfour_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('memberfour_error').innerHTML = "";
  }
}
function valMemberFive(){
  // alert('Js available');
  var memberfive = document.getElementById('memberfive').value;
  if (memberfive == ""){
    document.getElementById('memberfive_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('memberfive_error').innerHTML = "";
  }
}


function checkformMember() {
  var memberone = document.getElementById('memberone').value;
  var membertwo = document.getElementById('membertwo').value;
  var memberthree = document.getElementById('memberthree').value;
  var memberfour = document.getElementById('memberfour').value;
  var memberfive = document.getElementById('memberfive').value;

  if ((memberone == "") || (membertwo == "")|| (memberthree == "") || (memberfour == "") || (memberfive == "")) {
    document.getElementById('form_error').innerHTML = "*** Please, fill the form appropriately.";
    return false;
  } else {
    return true;
  }
}

// Validating Family Fields
function valFamilyOne() {
  // alert('Js available');
  var familyone = document.getElementById('familyone').value;
  if (familyone == ""){
    document.getElementById('familyone_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('familyone_error').innerHTML = "";
  }
}
function valFamilyTwo() {
  // alert('Js available');
  var familytwo = document.getElementById('familytwo').value;
  if (familytwo == ""){
    document.getElementById('familytwo_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('familytwo_error').innerHTML = "";
  }
}
function valFamilyThree() {
  // alert('Js available');
  var familythree = document.getElementById('familythree').value;
  if (familythree == ""){
    document.getElementById('familythree_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('familythree_error').innerHTML = "";
  }
}
function valFamilyFour() {
  // alert('Js available');
  var familyfour = document.getElementById('familyfour').value;
  if (familyfour == ""){
    document.getElementById('familyfour_error').innerHTML = "*** Required.";
    // alert('Js available');
  } else {
    document.getElementById('familyfour_error').innerHTML = "";
  }
}

function checkformFamily() {
  var familyone = document.getElementById('familyone').value;
  var familytwo = document.getElementById('familytwo').value;
  var familythree = document.getElementById('familythree').value;
  var familyfour = document.getElementById('familyfour').value;

  if ((familyone == "") || (familytwo == "")|| (familythree == "") || (familyfour == "")) {
    document.getElementById('form_error').innerHTML = "*** Please, fill the form appropriately.";
    return false;
  } else {
    return true;
  }
}


// 


