"use strict";
let subTotalPrice = 0;
let totalPrice = 0;
let taxAmount = 0;
let amountToRemove = 0;
let cart = JSON.parse(sessionStorage.getItem("cart"));
if (!cart) {
  cart = [];
}
console.log("cart", cart);
let cartSection = document.querySelector("#cartItems");
selectQ();

if (cart) {
  cart.forEach(cartItem => {
    let template = document.querySelector("#cartItemTemplate").content;
    let clone = template.cloneNode(true);
    clone.querySelector(".title_cart").textContent = cartItem.name;
    clone.querySelector(".img_cart").setAttribute("src", cartItem.img);
    clone.querySelector(".cartDiv").setAttribute("id", cartItem.id);
    clone.querySelector(".type_cart_grind").textContent = cartItem.typeGrind;
    clone.querySelector(".type_cart").textContent = cartItem.type;
    clone.querySelector(".price_cart").textContent = cartItem.price;
    clone.querySelector(".cart_quantity").value = cartItem.amount;
    clone.querySelector(".cart_quantity").addEventListener("input", function() {

      console.log(subTotalPrice);
      let oldCartItemAmount = cartItem.amount;
      cartItem.amount = event.target.value;

      let str = cartItem.amount;

      if (cartItem.amount == ''){
        console.log('no number inside');
        cartItem.amount = 0;
        
      };

      if(str.search("-") == 0){
        str = str.replace("-", "");
        cartItem.amount = str;
        console.log(cartItem.amount);
      }

      let previousPrice = parseInt(cartItem.price) * parseInt(oldCartItemAmount);
      let changedPrice = parseInt(cartItem.price) * parseInt(cartItem.amount);

      subTotalPrice = subTotalPrice - previousPrice + changedPrice;
      taxAmount = subTotalPrice * 0.25;
      totalPrice = subTotalPrice + taxAmount;

      // if (event.target.value < cartItem.amount) {
      //   cartItem.amount = event.target.value;
      //   subTotalPrice = subTotalPrice - parseInt(cartItem.price);
      //   taxAmount = subTotalPrice * 0.25;
      //   totalPrice = subTotalPrice - taxAmount;
      //   console.log(subTotalPrice);
      // } else {
      //   cartItem.amount = event.target.value;
      //   console.log(cartItem.amount);
      //   console.log(cartItem.price);
      //   subTotalPrice = subTotalPrice + parseInt(cartItem.price);
      //   console.log(subTotalPrice);
      //   taxAmount = subTotalPrice * 0.25;
      //   console.log(taxAmount);
      //   totalPrice = subTotalPrice + taxAmount;
      //   console.log(totalPrice);
      // }
      
      document.getElementById("tax").textContent = taxAmount + " DKK";
      document.getElementById("subsum").innerHTML = subTotalPrice + " DKK";
      document.getElementById("totalsum").innerHTML = totalPrice + " DKK";
    });
    let removeBtn = clone.querySelector(".remove");
    removeBtn.addEventListener("click", function() {
      console.log("removeItemId: ", cartItem.id);
      
      amountToRemove = parseInt(cartItem.price);
      console.log(amountToRemove);
      console.log(subTotalPrice);
      
      removeItem(cartItem.id, amountToRemove);
    });

    cartSection.appendChild(clone);
  });
  sessionStorage.setItem("cart", JSON.stringify(cart));
  console.log(sessionStorage);
} else {
  emptyTotal();
}

if (cart.length == 0) {
  displayGoBuyMessage();
}

// selectQ();

function displayGoBuyMessage() {
  console.log("go buy");
  document.querySelector(".cartTotal").style.display = "none";
  document.querySelector('.cart-header').classList.remove('text-left');
  document.querySelector('.cart-header').classList.remove('pl-medium');
  document.querySelector('.cart-header').classList.add('text-center');
  document.querySelector('.cart-header').textContent = "We're sorry"
  document.querySelector(".noCart").style.display = "block";
  document.querySelector(".cart-header").classList.remove("pl-large");
  
}

console.log(document.querySelector('.cart-header'));

function removeItem(cartItemId, amountToRemove) {
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  subTotalPrice = subTotalPrice - amountToRemove;
  cart.forEach(function(cartItem, index, object) {
    if (cartItem.id === cartItemId) {
      object.splice(index, 1);
    }
  });
  sessionStorage.setItem("cart", JSON.stringify(cart));

  let cartItemElement = document.getElementById(cartItemId);
  cartItemElement.remove();

  console.log(subTotalPrice);

  taxAmount = subTotalPrice*0.25;
  totalPrice = subTotalPrice + taxAmount;

  let text = "The item is succesfully removed from your cart";
  let responseClass = "success";
  showNotification(text, responseClass);

  checkCart();
  if (cart.length == 0) {
    displayGoBuyMessage();
  }
  // console.log()
  selectQRemove();
}

function selectQ() {
  let sectionTotal = document.getElementById("totalItemsSection");
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  console.log(cart);
  if (cart) {
    cart.forEach(cartItem => {
      subTotalPrice =
        subTotalPrice + parseInt(cartItem.price) * parseInt(cartItem.amount);
      
      taxAmount = subTotalPrice * 0.25;
      totalPrice = subTotalPrice + taxAmount;
      let template = document.querySelector("#totalItemsTemplate").content;
      let clone = template.cloneNode(true);

      sectionTotal.appendChild(clone);
    });
    console.log(subTotalPrice);
  }
  document.getElementById("tax").textContent = taxAmount + " DKK";
  document.getElementById("subsum").innerHTML = subTotalPrice + " DKK";
  document.getElementById("totalsum").innerHTML = totalPrice + " DKK";
}

function emptyTotal() {
  document.getElementById("tax").textContent = 0;
  document.getElementById("subsum").innerHTML = 0;
  document.getElementById("totalsum").innerHTML = 0;
}

function selectQRemove() {
  let sectionTotal = document.getElementById("totalItemsSection");
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  console.log(cart);
  document.getElementById("tax").textContent = taxAmount + " DKK";
  document.getElementById("subsum").innerHTML = subTotalPrice + " DKK";
  document.getElementById("totalsum").innerHTML = totalPrice + " DKK";
}

function emptyTotal() {
  document.getElementById("tax").textContent = 0;
  document.getElementById("subsum").innerHTML = 0;
  document.getElementById("totalsum").innerHTML = 0;
}
