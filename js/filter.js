"use strict";
window.addEventListener("load", init);

// VARIABLES WITH DOM ELEMENTS

const acc = document.getElementsByClassName("accordion");

const txtSearch = document.querySelector("#txtSearch");
const theResults = document.querySelector("#results");

//// Price checkboxes
let checkFirstOption = document.querySelector(".filter-price [name=option1]");
let checkSecondOption = document.querySelector(".filter-price [name=option2]");
let checkThirdOption = document.querySelector(".filter-price [name=option3]");

//// Coffee type checkboxes
let checkFirstCoffeeOption = document.querySelector(
  ".filter-origin [name=option1]"
);
let checkSecondCoffeeOption = document.querySelector(
  ".filter-origin [name=option2]"
);
let checkThirdCoffeeOption = document.querySelector(
  ".filter-origin [name=option3]"
);
let checkFourthCoffeeOption = document.querySelector(
  ".filter-origin [name=option4]"
);
let checkFifthCoffeeOption = document.querySelector(
  ".filter-origin [name=option5]"
);
let checkSixthCoffeeOption = document.querySelector(
  ".filter-origin [name=option6]"
);

function checkCoffeeType(product) {
  if (product.nCoffeeTypeID == 1) {
    product.nCoffeeTypeID = "Colombia";
  }
  if (product.nCoffeeTypeID == 2) {
    product.nCoffeeTypeID = "Ethiopia";
  }
  if (product.nCoffeeTypeID == 3) {
    product.nCoffeeTypeID = "Sumatra";
  }
  if (product.nCoffeeTypeID == 4) {
    product.nCoffeeTypeID = "Brazil";
  }
  if (product.nCoffeeTypeID == 5) {
    product.nCoffeeTypeID = "Nicaragua";
  }
  if (product.nCoffeeTypeID == 6) {
    product.nCoffeeTypeID = "Blend";
  }
}

function changeFormatForImg(product) {
  let str = product.cName;
  product.cName = str.replace(/\s+/g, "-").toLowerCase();
}

function changeFormatForName(product) {
  let str = product.productName;

  return (
    str
      .split(" ")
      .join("-")
      .toLowerCase() + ".png"
  );

  // console.log(product.productName);
}

// ACCORDION FUNCTION
for (let i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

// PRODUCTS FUNCTION
function getAllProductsAsJson() {
  let endpoint = "api/api-get-products.php";
  return new Promise((resolve, reject) => {
    fetch(endpoint)
      .then(res => res.json())
      .then(function(products) {
        resolve(products);
      });
  });
}

//// Coffee types
function iCoffeeTypeColombia(product) {
  return product.nCoffeeTypeID == 1;
}
function iCoffeeTypeEthiopia(product) {
  return product.nCoffeeTypeID == 2;
}
function iCoffeeTypeSumatra(product) {
  return product.nCoffeeTypeID == 3;
}
function iCoffeeTypeBrazil(product) {
  return product.nCoffeeTypeID == 4;
}
function iCoffeeTypeNicaragua(product) {
  return product.nCoffeeTypeID == 5;
}
function iCoffeeTypeBlend(product) {
  return product.nCoffeeTypeID == 6;
}

// FILTERING FUNCTION
function showFilteredCoffee(products) {
  document.querySelector(".products-container").innerHTML = "";
  let template = document.querySelector("template").content;
  products.forEach(product => {
    let clone = template.cloneNode(true);

    if (product.cName) {
      clone.querySelector("a").href = "singleProduct?id=" + product.nProductID;
      clone.querySelector("h3").textContent = product.cName;
      changeFormatForImg(product);
      clone.querySelector(".product").id = "product-" + product.nProductID;
      clone.querySelector(".image").style.backgroundImage =
        "url(img/products/" + product.cName + ".png)";
      clone.querySelector(".productCoffeeType").textContent =
        product.coffeeTypeName;
      clone.querySelector(".productPrice").textContent = product.nPrice + " DKK";
    } else {
      clone.querySelector("a").href = "singleProduct?id=" + product.nProductID;
      clone.querySelector("h3").textContent = product.productName;
      product.imagePath = changeFormatForName(product);
      clone.querySelector(".image").style.backgroundImage =
        "url(img/products/" + product.imagePath + ")";
      clone.querySelector(".productCoffeeType").textContent =
        product.typeName;
      clone.querySelector(".productPrice").textContent = product.nPrice + " DKK";
    }
    document.querySelector(".products-container").appendChild(clone);
  });

  let addProdToCartBtn = document.querySelectorAll(".addProdToCartBtn");
  let addSubToCartBtn = document.querySelectorAll(".addSubToCartBtn");
  console.log(addProdToCartBtn);

  
}

// INITIALIZING OF SEARCH FUNCTION ON INPUT
txtSearch.addEventListener("input", function() {
  fetchDataForSearch();
  if (txtSearch.value.length == 0 ) {
    theResults.style.display = "none";
  } else {
    theResults.style.display = "block";
  }
});

// SEARCH FUNCTION WITH API FOR SELECT *
function fetchDataForSearch() {
  fetch("api/api-search.php?search=" + txtSearch.value)
    .then(function(response) {
      return response.json();
    })
    .then(function(arrayMatches) {
      console.log({ arrayMatches });

      theResults.textContent = "";

      arrayMatches.forEach(function(match) {
        let a = document.createElement("a");
        let p = document.createElement("p");
        let image = document.createElement("div");
        console.log(match["cName"]);

        a.href = "singleProduct?id=" + match.nProductID;
        a.classList.add(
          "grid",
          "grid-one-fifth",
          "align-items-center",
          "pt-small"
        );
        a.append(image, p);
        image.classList.add("image", "bg-contain");
        p.innerHTML = "<strong>" + match.cName + "</strong>";
        changeFormatForImg(match);
        image.style.backgroundImage =
          "url(img/products/" + match.cName + ".png)";
        theResults.append(a);
      // console.log(theResults)
      });
    });
}

//SEARCH FUNCTION WITH API WITH SPECIFIC QUERY
document.querySelector("#searchBtn").addEventListener("click", () => {
  event.preventDefault();
  fetchDataForSearchBtn();
  theResults.style.display="none";
});

document.addEventListener("click", function(){
  if(event.target != theResults){
    theResults.style.display="none";
  }
})

function fetchDataForSearchBtn() {
  fetch("api/api-search-sql.php?search=" + txtSearch.value)
    .then(function(response) {
      return response.json();
    })
    .then(function(searchResultsArray) {
      console.log({ searchResultsArray });
      document.querySelector("#forSearch").style.visibility="initial";
      document.querySelector(".span1").innerHTML = searchResultsArray.length +" ";
      document.querySelector(".span2").innerHTML = txtSearch.value;
      
        
      showFilteredCoffee(searchResultsArray);
      // let inputText = document.querySelector(".products-container");
      // cachedHtml = inputText.innerHTML;
      highlight(
        document.querySelector(".products-container"),
        txtSearch.value,
        "highlight"
      );
      // theResults.textContent = "";

      // arrayMatches.forEach(function(match) {
      //   let a = document.createElement("a");
      //   a.href = "singleProduct.php?id=" + match.nProductID;
      //   a.textContent = match.cName;
      //   let span = document.createElement("br");
      //   theResults.append(a, span);
      // });
    });
}

// function highlight(text) {
//   let inputText = document.querySelectorAll(".mt-small");
//   inputText.forEach(input => {
//     let innerHTML = input.textContent;
//     console.log({ innerHTML });
//     let index = innerHTML.indexOf(text);
//     let regexp = new RegExp(text, "gi");

//     if (index >= 0) {
//       // innerHTML =
//       //   innerHTML.substring(0, index) +
//       //   "<span class='highlight'>" +
//       //   innerHTML.substring(index, index + text.length) +
//       //   "</span>" +
//       //   innerHTML.substring(index + text.length);
//       input.innerHTML = innerHTML.replace(
//         regexp,
//         `<span class="highlight">${text}</span>`
//       );
//       console.log(input.innerHTML);
//     }
//   });
// }

function highlight(container, what, spanClass) {
  var content = container.innerHTML,
    pattern = new RegExp("(>[^<.]*)(" + what + ")([^<.]*)", "g"),
    replaceWith =
      "$1<span " +
      (spanClass ? 'class="' + spanClass + '"' : "") +
      '">$2</span>$3',
    highlighted = content.replace(pattern, replaceWith);
  return (container.innerHTML = highlighted) !== content;
}

// Listen to range change
let rangeInput = document.querySelector("#rangePrice");
let priceValueElm = document.querySelector("#priceValue");

let filters = {
  coffeTypeNames: [],
  priceRange: rangeInput.value
};

let products = [];

const priceFilter = (products, filters) => {
  return products.filter(product => product.price < filters.priceRange);
};

const typeFilter = (products, filters) => {
  if (!filters.coffeTypeNames.length) return products;

  return products.filter(product =>
    filters.coffeTypeNames.includes(product.coffeeTypeName)
  );
};

rangeInput.addEventListener("change", () => {
  filters.priceRange = rangeInput.value;
  priceValueElm.textContent = rangeInput.value + " " + " DKK";
  runFilters(products, filters);
});

const convertProducts = products => {
  return products.map(product => {
    product.coffeeTypeName = checkCoffeeType(product);
    product.price = +product.nPrice;

    return product;
  });
};

let coffeetypesDiv = document.querySelector("#coffeeTypesdiv");
coffeetypesDiv.addEventListener("click", element => {
  // debugger;
  if (element.target.localName == "input") {
    
      
    changeSelectedCoffeeType(element.target);
  }
});

const runFilters = (products, filters) => {
  let filtered = priceFilter(products, filters);
  filtered = typeFilter(filtered, filters);

  showFilteredCoffee(filtered);
};

function changeSelectedCoffeeType(checkbox) {
  if (checkbox.checked) {
    filters.coffeTypeNames.push(checkbox.value);
  } else {
    filters.coffeTypeNames = filters.coffeTypeNames.filter(
      name => name !== checkbox.value
    );
  }

  runFilters(products, filters);
}

async function init() {
  priceValueElm.textContent = rangeInput.value + " " + " DKK";

  products = await getAllProductsAsJson();
  products = convertProducts(products);
  document.querySelector("#txtSearch").addEventListener("mouseout", () => {
    if (!document.querySelector("#txtSearch").value) {
      document.querySelector("#forSearch").innerHTML = "";
      showFilteredCoffee(products);
    }
  });
  
}

function checkCoffeeType(product) {
  if (product.nCoffeeTypeID == 1) {
    return "Colombia";
  }
  if (product.nCoffeeTypeID == 2) {
    return "Ethiopia";
  }
  if (product.nCoffeeTypeID == 3) {
    return "Sumatra";
  }
  if (product.nCoffeeTypeID == 4) {
    return "Brazil";
  }
  if (product.nCoffeeTypeID == 5) {
    return "Nicaragua";
  }
  if (product.nCoffeeTypeID == 6) {
    return "Blend";
  }
}


// SESSION STORAGE


// if(InputNumberofBags){
//   let totalAmountNumber = totalAmountElm.textContent.substr(0,totalAmountElm.textContent.search(" ")-1);
  
//   InputNumberofBags.addEventListener("input", function(){
//     // console.log(Number(totalAmountNumber))
//     totalAmountElm.textContent = (InputNumberofBags.value*Number(totalAmountNumber)) + ".00 DKK";
//   })

// }
// function createCartItem() {
//   let cartItem = {
//     id: 0,
//     img: "",
//     name: "",
//     price: 0,
//     amount: 0,
//     typeGrind: "",
//     type: ""
//   };
//   return cartItem;
// }

// // let currentCartItem = {};

// function getCartItem() {
//   let cartItem = createCartItem();
//   let urlParams = new URLSearchParams(window.location.search);
//   let itemId = urlParams.get("id");
//   cartItem.id = itemId;
//   let itemName = document.querySelector(".productName").innerHTML;
//   cartItem.name = itemName;
//   let price = document.querySelector(".productPrice").innerHTML;
//   cartItem.price = price;

//   let type = document.querySelector(".productCoffeeType").innerHTML;
//   cartItem.type = type;

//   let imgPath = changeFormatName(itemName);
//   let img = "img/products/" + imgPath;
//   cartItem.img = img;
//   let checkedValue = document.querySelector(".mb-small:checked").value;
//   cartItem.typeGrind = checkedValue;
//   let amountSelected = document.querySelector('input[name="option1"]').value;
//   cartItem.amount = amountSelected;
//   let purchaseType = "product";
//   cartItem.purchaseType = purchaseType;
//   console.log(cartItem);
//   currentCartItem = cartItem;
// }
// function getSubCartItem(id){
//   let parent = document.getElementById(id);
//   console.log(parent)
//   let cartItem =createCartItem();
//   let itemID = id;
//   cartItem.id = itemID
//   let itemName = parent.querySelector(".subscriptionName").innerHTML;
//   cartItem.name = itemName
//   let imgElm = parent.querySelector("img");
//   let img = imgElm.getAttribute("src");
//   cartItem.img = img;

//   let type = document.querySelector(".productCoffeeType").innerHTML;
//   cartItem.type = type;

//   let typeGrind = "Whole";
//   cartItem.typeGrind = typeGrind;
//   let price = parent.querySelector(".priceSubscription").innerHTML;
//   cartItem.price = price;
//   let purchaseType = "subscription";
//   cartItem.purchaseType = purchaseType;
//   let quantity = 1;
//   cartItem.amount = quantity;
//   currentCartItem = cartItem;
//   }

//   function getProdCartItem(id){
//     let parent = document.getElementById(id);
//     console.log(parent)

//     let cartItem =createCartItem();
//     let itemID = id;
//     cartItem.id = itemID;

//     let itemName = parent.querySelector(".productName").innerHTML;
//     cartItem.name = itemName;
//     let price = parent.querySelector(".productPrice").innerHTML;
//     cartItem.price = price;
//     let imgPath = changeFormatName(itemName);
//     let img = "img/products/" + imgPath;
//     cartItem.img = img;
//     cartItem.typeGrind = "Whole";

//     let type = document.querySelector(".productCoffeeType").innerHTML;
//     cartItem.type = type;

//     cartItem.amount = 1;
//     let purchaseType = "product";
//     cartItem.purchaseType = purchaseType;
//     console.log(cartItem);
//     currentCartItem = cartItem;
//     }

// function changeFormatName(str) {
//   return (
//     str
//       .split(" ")
//       .join("-")
//       .toLowerCase() + ".png"
//   );
// }