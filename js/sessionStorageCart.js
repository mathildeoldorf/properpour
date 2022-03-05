"use strict";

let addToCartBtn = document.querySelector("#addToCartBtn");
let cartItem = document.querySelector("#cartItem");
let addSubToCartBtn = document.querySelectorAll(".addSubToCartBtn");
let addProdToCartBtn = document.querySelectorAll(".addProdToCartBtn");
const InputNumberofBags = document.querySelector("[name=option1]");
let totalAmountElm = document.querySelector(".totalPrice");

// let numberOfItem = document.querySelector(".numberOfItems");
// checkCart();
if(InputNumberofBags){
  let totalAmountNumber = totalAmountElm.textContent.substr(0,totalAmountElm.textContent.search(" ")-1);
  
  InputNumberofBags.addEventListener("input", function(){
    // console.log(Number(totalAmountNumber))
    totalAmountElm.textContent = (InputNumberofBags.value*Number(totalAmountNumber)) + ".00 DKK";
  })

}

function createCartItem() {
  let cartItem = {
    id: 0,
    img: "",
    name: "",
    price: 0,
    amount: 0,
    typeGrind: "",
    type: ""
  };
  return cartItem;
}

let currentCartItem = {};

function getCartItem() {
  let cartItem = createCartItem();
  let urlParams = new URLSearchParams(window.location.search);
  let itemId = urlParams.get("id");
  cartItem.id = itemId;
  let itemName = document.querySelector(".productName").innerHTML;
  cartItem.name = itemName;
  let price = document.querySelector(".productPrice").innerHTML;
  cartItem.price = price;

  let type = document.querySelector(".productCoffeeType").innerHTML;
  cartItem.type = type;

  let imgPath = changeFormatName(itemName);
  let img = "img/products/" + imgPath;
  cartItem.img = img;
  let checkedValue = document.querySelector(".mb-small:checked").value;
  cartItem.typeGrind = checkedValue;
  let amountSelected = document.querySelector('input[name="option1"]').value;
  cartItem.amount = amountSelected;
  let purchaseType = "product";
  cartItem.purchaseType = purchaseType;
  console.log(cartItem);
  currentCartItem = cartItem;
}


function getSubCartItem(id){
  let parent = document.getElementById(id);
  console.log(parent)
  let cartItem =createCartItem();
  let itemID = id;
  cartItem.id = itemID
  let itemName = parent.querySelector(".subscriptionName").innerHTML;
  cartItem.name = itemName
  let imgElm = parent.querySelector("img");
  let img = imgElm.getAttribute("src");
  cartItem.img = img;

  let type = document.querySelector(".productCoffeeType").innerHTML;
  cartItem.type = type;

  let typeGrind = "Whole";
  cartItem.typeGrind = typeGrind;
  let price = parent.querySelector(".priceSubscription").innerHTML;
  cartItem.price = price;
  let purchaseType = "subscription";
  cartItem.purchaseType = purchaseType;
  let quantity = 1;
  cartItem.amount = quantity;
  currentCartItem = cartItem;
  }

  function getProdCartItem(id){
    let parent = document.getElementById(id);
    console.log(parent)

    let cartItem =createCartItem();
    let itemID = id;
    cartItem.id = itemID;

    let itemName = parent.querySelector(".productName").innerHTML;
    cartItem.name = itemName;
    let price = parent.querySelector(".productPrice").innerHTML;
    cartItem.price = price;
    let imgPath = changeFormatName(itemName);
    let img = "img/products/" + imgPath;
    cartItem.img = img;
    // let checkedValue = parent.querySelector(".mb-small:checked").value;
    cartItem.typeGrind = "Whole";
    // let amountSelected = parent.querySelector('input[name="option1"]').value;

    let type = document.querySelector(".productCoffeeType").innerHTML;
    cartItem.type = type;

    cartItem.amount = 1;
    let purchaseType = "product";
    cartItem.purchaseType = purchaseType;
    console.log(cartItem);
    currentCartItem = cartItem;
    }

function changeFormatName(str) {
  return (
    str
      .split(" ")
      .join("-")
      .toLowerCase() + ".png"
  );
}

// function checkCart() {
//   let cart = JSON.parse(sessionStorage.getItem("cart"));

//   if (cart && cart.length > 0) {
//     numberOfItem.innerHTML = cart.length;
//     numberOfItem.setAttribute("style", "display:block;");
//   } else {
//     numberOfItem.setAttribute("style", "display: none;");
//   }
// }
document.addEventListener("click", function(){

  let e = event.target;
  let addSubToCartBtn = document.querySelectorAll(".addSubToCartBtn");
  let addProdToCartBtn = document.querySelectorAll(".addProdToCartBtn");

  console.log(e)
  if(e == document.querySelector(".addTestSubToCartBtn")){
    console.log("purchase from test")
    let parentID = event.target.parentElement.parentElement.id
        getSubCartItem(parentID)
        initialiseCart();
        let text = "Added to Cart" ;
        let responseClass = "success";
        showNotification(text, responseClass)
  }
  
})

if(addSubToCartBtn){
  addSubToCartBtn.forEach(subToCartBtn=>{
    subToCartBtn.addEventListener("click",()=>{
      event.preventDefault();
      let parentID = event.target.parentElement.id;
  console.log(event.target.parentElement)
  console.log("here");
  getSubCartItem(parentID)
  initialiseCart();
  let text = "Added to Cart" ;
  let responseClass = "success";
      showNotification(text, responseClass)
    })
  })
}

if(addProdToCartBtn){
  addProdToCartBtn.forEach(prodToCartBtn=>{
    prodToCartBtn.addEventListener("click",()=>{
      console.log('clicked');
      event.preventDefault();
      let parentID = event.target.parentElement.id;
  
      getProdCartItem(parentID)
      initialiseCart();
      let text = "Added to Cart" ;
      let responseClass = "success";
      showNotification(text, responseClass)
    })
  })
}



if(addToCartBtn){
addToCartBtn.addEventListener("click", () => {
  getCartItem();
  initialiseCart()
  let text = "Added to Cart" ;
  let responseClass = "success";
  showNotification(text, responseClass)
 });
}


function initialiseCart(){
  
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  if (cart) {
    //adds one or more elements to the array cart
    cart.push(currentCartItem);
    sessionStorage.setItem("cart", JSON.stringify(cart));
  } else {
    cart = [];
    cart.push(currentCartItem);
    sessionStorage.setItem("cart", JSON.stringify(cart));
  }

  checkCart();
}