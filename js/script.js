"use strict";

function changeFormatForImg(product) {
  let str = product.cName;
  product.cName = str.replace(/\s+/g, "-").toLowerCase();
}

// TOGGLE PASSWORD VISIBILITY

function togglePasswordVisibility(){
  let passwordInputs = document.querySelectorAll(".password");
 
  console.log(passwordInputs);
  passwordInputs.forEach(passwordInput=>{
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
    } else {
      passwordInput.type = "password";
    }
  })
}


// NOTIFICATIONS

function showNotification(text, responseClass){
  let notificationContainer = document.createElement("div");
  notificationContainer.className = "notification-container grid justify-items-center align-items-center " + responseClass;

  let textElement = document.createElement("p");
  textElement.textContent = text;

  notificationContainer.append(textElement);
  document.querySelector('body').append(notificationContainer);

  setTimeout(function(){
      document.querySelector('.notification-container').remove();
  }, 2600);
}
//


// LOGOUT

if(document.querySelector(".button-log-out")){
  document.querySelectorAll(".button-log-out").forEach(logOutBtn=>{
    logOutBtn.addEventListener("click", logout);
  })
}

function logout(){
    console.log('click');
    let endpoint = "api/api-logout.php";
    // console.log("delte user");
        fetch(endpoint, {
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            window.location.href = "log-out";
        });
}

// TEST


// window.addEventListener("load", init);
// function init() {
// }
 
function removeSelected() {
  document.querySelectorAll(".selectedItem").forEach(name => {
    name.classList.remove("selectedItem");
  });
}

if (document.querySelector(".back-button")) {
  // console.log("yes");
  document.querySelector(".back-button").addEventListener("click", function() {
    window.history.back();
  });
}

function checkCart() {
  // console.log("check cart")
  let numberOfItemElms = document.querySelectorAll(".numberOfItems");
  let cart = JSON.parse(sessionStorage.getItem("cart"));

  numberOfItemElms.forEach(numberOfItem=>{
  if (cart && cart.length > 0) {
    numberOfItem.innerHTML = cart.length;
    numberOfItem.setAttribute("style", "display:inline;");
  } else {
    numberOfItem.setAttribute("style", "display: none;");
  }
})
}

checkCart();