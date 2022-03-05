"use strict";

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log(cart);

if (cart) {
  let title = document.querySelector(".productName");
  let img = document.querySelector(".productImg");
  let amountPayed = document.querySelector(".amountPayed");
  let netAmount = document.querySelector(".netamount_cart");
  let taxAmount = document.querySelector(".tax_cart");
  let coffeeType = document.querySelector(".coffeeType");
  let date = document.querySelector(".date");
  title.textContent = cart[0].name;
  img.setAttribute("src", cart[0].img);
  console.log(cart[0].price);
  let price = cart[0].price.substr(0, cart[0].price.search(" "));
  console.log(price);
  amountPayed.textContent = price * 1.25 + " DKK";
  netAmount.textContent = price + " DKK";
  taxAmount.textContent = price * 0.25 + " DKK";
  coffeeType.textContent = cart[0].type;
  
  sessionStorage.removeItem("cart");


  let today = new Date();
  let dd = String(today.getDate()).padStart(2, '0');
  let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  let yyyy = today.getFullYear();
  let hour = today.getHours();
  let minutes = today.getMinutes();
  let seconds = today.getSeconds();

  today = yyyy + '-' + mm + '-' + dd + ' ' + hour + ':' + minutes + ':' + seconds;
  date.textContent = today;
} else {
  location.href = "cart";
}
