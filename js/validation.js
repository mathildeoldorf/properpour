function checkIfFormValid(idForm) {
  console.log({ idForm });
  let form = document.querySelector(idForm);
  console.log({ form });
  let allInputs = document.querySelectorAll("input");
  allInputs.forEach(input => {
    input.addEventListener("input", function() {
      // console.log(form.checkValidity());
      if (form.checkValidity()) {
        form.querySelector("button").removeAttribute("disabled");
      } else {
        form.querySelector("button").setAttribute("disabled", true);
      }
    });
  });
}

if(document.referrer.indexOf("cart")!=-1 && window.location.pathname == "/db_properpour/db_exam/log-in"){
  responseClass="fail";
  text = "You have to be logged in to make a purchase";
  showNotification(text, responseClass)
}

function doLogin(){
  let loginInput = document.querySelector("[name=inputEmail]").value;
  let loginPassword = document.querySelector("[name=password]").value;
  let formData = new FormData();
  formData.append("inputEmail", loginInput);
  formData.append("password", loginPassword);
  let endpoint = "api/api-login.php";
  fetch(endpoint, {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(response => {
      console.log(response);
      if (response == 1) {
        console.log("profile")
        console.log(response);
        console.log(document.referrer.indexOf("cart"));

        let cart = JSON.parse(sessionStorage.getItem("cart"));
        if (!cart) {
        cart = [];
        }

        console.log(cart.length);


        if(cart.length != 0){
          location.href = "cart";
          let text = "Welcome. Please proceed with your purchase";
          let responseClass = "success";
          showNotification(text, responseClass);
        }else{
          
          location.href = "profile";
          let text = "Welcome to your profile";
          let responseClass = "success";
          showNotification(text, responseClass);
        }
      }
      if (response == 0) {

        let text = "Something went wrong, please try again";
        let responseClass = "fail";
        showNotification(text, responseClass);
      }
    });
};   

// function fvIsEmailAvailable(oElement) {
//   console.log({ oElement });
//   var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//   if (re.test(String(oElement.value).toLowerCase())) {
//     console.log(re.test(String(oElement.value).toLowerCase()))
//     // oElement.classList.add('error')
//     fvGet(
//       "api/api-is-user-registered.php?email=" + oElement.value,
//       "",
//       function(sData) {
//         console.log({ sData });
//         var jData = JSON.parse(sData);
//         console.log({ jData });
//         if (jData) {
//           // console.log('error')
//           document.querySelector("#emailDiv").innerText =
//             "email already registered";
//           oElement.setCustomValidity("Invalid field.");
//           oElement.classList.add("error");
//           signUpForm.querySelector("button").setAttribute("disabled", true);
//           return;
//         }
//         // console.log('ok')
//         oElement.setCustomValidity("");
//         document.querySelector("#emailDiv").innerText =
//           "email available for registration";
//         oElement.classList.remove("error");
//         signUpForm.querySelector("button").removeAttribute("disabled");
//       }
//     );
//   }
  // else {
  //   // not valid email yet
  //   document.querySelector("#emailDiv").innerText = "email";
  //   oElement.classList.remove("error");
  // }
// }

function fvGet(sUrl, sHeader, fCallback) {
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fCallback(ajax.responseText);
    } else if (this.readyState == 4 && this.status != 200) {
      // console.log( this.status )
    }
  };
  ajax.open("GET", sUrl, true);
  if (sHeader == "x-partial") {
    ajax.setRequestHeader("X-PARTIAL", "YES");
  }
  ajax.send();
}


if (document.querySelectorAll("form")) {
  let forms = document.querySelectorAll("form");
  console.log(forms.length)
  forms.forEach(form=>{
    checkIfFormIsValid(form)

  if(form.id == "loginForm"){
   
    const loginBtn = document.querySelector("#loginBtn");
    loginBtn.addEventListener("click", () => {
      event.preventDefault();
      doLogin();
    });
  }
})
}


function checkIfFormIsValid(form){
  if(form.id == "signupForm"){
    console.log('signup');
    allTabs = form.querySelectorAll(".tab");
    allTabs.forEach(tab=>{
      allInputs = tab.querySelectorAll("[data-type]");

      console.log(document.querySelector("#nextBtn"));
        allInputs.forEach(input=>{
            input.addEventListener('input', function(){
                if(form.querySelectorAll('.valid').length == 5){
                  document.querySelector("#nextBtn").disabled=false;
                }
                else if(checkInputFields(input,form) == true){
                  tab.querySelector(".formBtn").disabled=false;
                }
                else{
                  document.querySelector("#nextBtn").disabled=true;
                }
            })
        });
    });

    allInputs = form.querySelectorAll("[data-type]");
    allInputs.forEach(input=>{
    input.addEventListener('input', function(){
      if(checkInputFields(input,form) == true){
        form.querySelectorAll(".formBtn").disabled=false;
      }else{
        form.querySelectorAll(".formBtn").disabled=true;
      }
    });
  });

  }

  else{

    allInputs = form.querySelectorAll("[data-type]");
    allInputs.forEach(input=>{
      input.addEventListener('input', function(){
        if(checkInputFields(input,form) == true){
          console.log('true');
          form.querySelector(".formBtn").disabled=false;
        }else{
          form.querySelector(".formBtn").disabled=true;
        }
    });
  });

  }
}


function checkInputFields(input,form){
  let sValue = input.value;
  let sDataType = input.getAttribute("data-type")
  let iMin = input.getAttribute('data-min') 
  let iMax = input.getAttribute('data-max')
  console.log()
  switch(sDataType){
    case 'string':
      if( sValue.length < iMin || sValue.length > iMax ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break
    case 'integer':
      if( !parseInt(sValue) || parseInt(sValue) < parseInt(iMin) || parseInt(sValue) > parseInt(iMax) ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break
    case 'email':
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if( re.test(String(sValue).toLowerCase()) == false ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break  
    case 'password':
      const password_1 = document.querySelector("[name='password_1']");
      const password_2 = document.querySelector("[name='password_2']");

      if(password_1.value.length < 8){
        input.classList.add('error');
        input.classList.remove('valid');
      }
      else{
        input.classList.add('valid');
          input.classList.remove('error');

        if(password_1.value !== password_2.value){
          password_2.classList.add('error')
          password_2.classList.remove('valid')
        }    
        else{
          input.classList.add('valid');
          input.classList.remove('error');
        }
      }
      
    default:        
  }
   if( form.querySelectorAll('.error').length==0 && form.checkValidity()){
    return true;
  }else{
    return false;
  }
 
}   

