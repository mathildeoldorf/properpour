"use strict";

// CREATING A USER

const createUserBtn = document.getElementsByName("reg_user")[0];

// FORM IN TWO STEPS

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  console.log(x);
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    // document.getElementById("prevBtn").style.display = "none";
  } else {
    // document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").style.display = "none";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }

}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  // if (n == 1) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;

  console.log(x.length);
  console.log(currentTab);
  // if you have reached the end of the form... :
  if (currentTab = 1) {

    showTab(currentTab);

    console.log(x.length);
    //...the form gets submitted:
    createUserBtn.addEventListener("click", () => {
      event.preventDefault();

      

      addNewUser();
    });
    // document.getElementById("signupForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}




function addNewUser() {
  let endpoint = "api/api-create-new-user.php";

  let userName = document.querySelector("[name=inputName]").value;
  let userLastName = document.querySelector("[name=inputLastName]").value;
  let userEmail = document.querySelector("[name=inputEmail]").value;
  let userAddress = document.querySelector("[name=inputAddress]").value;
  let userPassword = document.querySelector("[name=password_1]").value;
  let userPassword2 = document.querySelector("[name=password_2]").value;
  let userLoginName = document.querySelector("[name=inputLoginName]").value;
  let userPhone = document.querySelector("[name=inputPhone]").value;
  let cityID = document.querySelector("[name=cityInput]").value;

  console.log(userAddress, userEmail, userEmail, userLastName, userLoginName, userPassword, userPassword2, userPhone);
  

  let formData = new FormData();
  formData.append("inputName", userName);
  formData.append("inputLastName", userLastName);
  formData.append("inputEmail", userEmail);
  formData.append("inputPhone", userPhone);
  formData.append("inputLoginName", userLoginName);
  formData.append("password_1", userPassword);
  formData.append("password_2", userPassword2);
  formData.append("inputAddress", userAddress);
  formData.append("cityInput", cityID);

  console.log(userName, userLastName, cityID);
  fetch(endpoint, {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(response => {
      console.log(response);
      if (response == 1) {
        console.log('signed up');
        console.log(response);

        console.log(document.referrer.indexOf("cart"))

        let cart = JSON.parse(sessionStorage.getItem("cart"));
        if (!cart) {
        cart = [];
        }

        console.log(cart.length);

       if(cart.length == 0){
        // if(document.referrer.indexOf("cart")!=-1){
          location.href = "profile";
        // }
       }
       else{
        // if(document.referrer.indexOf("cart")==-1){
          window.history.go(-2);
        // }
       }

      }
      else{
        console.log('not signed up');
        let text = "You are already signed up. Please login";
        let responseClass = "fail";
        showNotification(text, responseClass);
        setTimeout(function(){
          console.log('User exists');
          location.href = "log-in";
        }, 1800);
      }
    });
}
