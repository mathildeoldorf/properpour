// CONSTANTS

const editButton = document.querySelector('.button-edit');
const saveButton = document.querySelector('.button-save');

const profileInfoButton = document.querySelector('.profile-info');
const orderInfoButton = document.querySelector('.order-info');
const favoritesButton = document.querySelector('.favoritesButton');
const subscriptionInfoButton = document.querySelector('.subscriptions-info');
const paymentInfoButton = document.querySelector('.payment-info');

const sectionForForms = document.querySelector('.profile .section-one');
const sectionWithSubscriptions = document.querySelector('.current-subscriptions');

const sectionForFavorites = document.querySelector('.favorites');
const containerForFavorites = document.querySelectorAll('.current-favorites');

const headerForFavorites = document.createElement('h2');
        headerForFavorites.className ="text-left mb-medium";
        headerForFavorites.innerText = "Your favorites";

const profileForm = document.querySelector('.profile-info-container');
profileForm.style.WebkitTransition = 'opacity 0.3s';

const creditcardForm = document.querySelector('.form-profile-form-container-creditcard');
creditcardForm.style.WebkitTransition = 'opacity 0.3s';
const creditCardScroll = document.querySelector('.form-creditcard');

const ordersContainer = document.querySelector('.orders-container');

const orderButtons = document.querySelectorAll('.order-button');

//// ORDER BUTTONS HOVER

orderButtons.forEach(orderButton=>{
    const orderContent = orderButton.querySelector('.order');
    orderButton.addEventListener("mouseover", function(){
        orderButton.querySelector('.see-details').style.opacity = 1;
        orderContent.style.opacity = 0;
    });

    orderButton.addEventListener("mouseout", function(){
        orderButton.querySelector('.see-details').style.opacity = 0;
        orderContent.style.opacity = 1;
    });
});

//// SHOW FAVORITES

favoritesButton.addEventListener('click', function(){
    event.preventDefault();
    sectionForFavorites.classList.toggle('hide');
    
    profileForm.classList.add('hide');
    sectionForForms.classList.add('hide');
    creditcardForm.classList.add('hide');
    ordersContainer.classList.add('hide');
    sectionWithSubscriptions.classList.add('hide');
    sectionForFavorites.scrollIntoView();

    getAllFavoritesAsJson();
});

function getAllFavoritesAsJson() {

    let endpoint = "api/api-get-favorites.php";

      fetch(endpoint)
      .then(res => res.json())
      .then(response => {
          showAllFavorites(response);
        });
}

function showAllFavorites(favorites){
    sectionForFavorites.prepend(headerForFavorites);

    if(favorites === 0){
        console.log('no favorites');
        getPopularFavorites();
    }
    else{
        console.log('showing favorites');

        favorites.forEach(favorite => {

        

        let favoriteLink = document.createElement('a');
        favoriteLink.setAttribute('href', 'singleProduct?id='+favorite.nProductID);

        let div = document.createElement('div');
        div.className = "product relative";
        div.setAttribute('id', 'favorite-'+favorite.nProductID);

        favoriteLink.append(div);

        let h3Favorite = document.createElement('h3');
        h3Favorite.className = 'productName mt-small text-left';
        h3Favorite.textContent = favorite.cName;

        changeFormatForImg(favorite);
        let image = document.createElement('div');
        image.className = 'image bg-contain';
        image.style.backgroundImage = 'url(img/products/'+favorite.cName+'.png)';

        let description = document.createElement('div');
        description.className = 'description m-small';

        let pCoffeeType = document.createElement('p');
        pCoffeeType.className = 'productCoffeeType, mt-small text-left';
        pCoffeeType.textContent = favorite.cCoffeeName;

        let h4Price = document.createElement('h4');
        h4Price.className = 'productPrice mt-small absolute';
        h4Price.textContent = favorite.nPrice+ ' DKK';

        description.append(h3Favorite, pCoffeeType, h4Price);

        let favoriteButton = document.createElement('a');
        favoriteButton.className = 'likeBtn align-items-center mv-small';

        let favoriteIcon = document.createElement('div');
        favoriteIcon.className = 'likeBtnIcon active bg-contain';

        favoriteButton.append(favoriteIcon);

        div.append(image, description, favoriteButton);

        document.querySelector('.current-favorites').append(div);
    
    });

    const hearts = document.querySelectorAll(".likeBtn");

    hearts.forEach(heart=>{
        
        heart.addEventListener("click", function(){
            let text = "Are you sure you want to remove this coffee from favorites?";
            let deleteType = "favorite";

            let favoriteID = heart.parentElement.id.substr(heart.parentElement.id.search("-")+1,heart.parentElement.id.length);
            console.log(favoriteID);
        
            showModal(text, deleteType, favoriteID);       
        });   
    });
    }
    
}

// SHOW PROFILE INFO FORM

profileInfoButton.addEventListener('click', function(){
    event.preventDefault();
    sectionForForms.classList.toggle('hide');
    profileForm.classList.toggle('hide');
    sectionForForms.classList.remove('hide');
    creditcardForm.classList.add('hide');
    ordersContainer.classList.add('hide');
    sectionForFavorites.classList.add('hide');
    sectionWithSubscriptions.classList.add('hide');
    profileForm.scrollIntoView();
});

// SHOW PAYMENT INFO FORM

paymentInfoButton.addEventListener('click', function(){
    event.preventDefault();
    
    sectionForForms.classList.toggle('hide');
    creditcardForm.classList.toggle('hide');
    sectionForForms.classList.remove('hide');
    profileForm.classList.add('hide');
    ordersContainer.classList.add('hide');
    sectionForFavorites.classList.add('hide');
    sectionWithSubscriptions.classList.add('hide');
    // window.scrollTo(0, 0);
    creditcardForm.scrollIntoView();
});

// SHOW SUBSCRIPTIONS

subscriptionInfoButton.addEventListener('click', function(){
    event.preventDefault();
    sectionForForms.classList.add('hide');
    creditcardForm.classList.add('hide');
    profileForm.classList.add('hide');
    ordersContainer.classList.add('hide');
    sectionForFavorites.classList.add('hide');
    sectionWithSubscriptions.classList.toggle('hide');
    sectionWithSubscriptions.scrollIntoView();

});

// SHOW ORDERS
orderInfoButton.addEventListener('click', function(){
    console.log('orders clicked');
    event.preventDefault();
    
    sectionForForms.classList.toggle('hide');
    ordersContainer.classList.toggle('hide');
    sectionForForms.classList.remove('hide');
    creditcardForm.classList.add('hide');
    profileForm.classList.add('hide');
    sectionForFavorites.classList.add('hide');
    sectionWithSubscriptions.classList.add('hide');
    ordersContainer.scrollIntoView();
});

// LOAD ALL ORDERS

const loadAllOrdersButton = document.querySelector('.loadAllOrders');

loadAllOrdersButton.addEventListener('click', function(){
    event.preventDefault();
    getAllOrdersAsJson();
    loadAllOrdersButton.style.display = 'none';
});

function getAllOrdersAsJson() {
    console.log('inside');
    let endpoint = "api/api-get-orders.php";

    return new Promise((resolve, reject) => {
      fetch(endpoint)
      .then(res => res.json())
      .then(response => {
          console.log(response);

          showAllOrders(response);
        });
    });
}

function showAllOrders(orders){
    console.log(orders);

    orders.forEach(order => {
        console.log('hej');
        console.log(order.dPurchase);

        let orderLink = document.createElement('a');
        orderLink.setAttribute('href', 'singleOrder?id='+order.nPurchaseID);
        orderLink.className = "order-button mh-medium";

        let div = document.createElement('div');
        div.className = "relative";

        orderLink.append(div);

        let grid = document.createElement('div');
        grid.className = "pl-small align-items-center absolute product order relative grid grid-seven";
        grid.setAttribute('id', 'order-'+order.nPurchaseID);

        let pOrderNo = document.createElement('p');
        pOrderNo.className = "orderNo grid text-left";
        pOrderNo.textContent = order.nPurchaseID;

        let pProductName = document.createElement('p');
        pProductName.className = "productName grid text-left";
        pProductName.textContent = order.cProductName;

        let pCoffeeType = document.createElement('p');
        pCoffeeType.className = "productCoffeeType grid text-left";
        pCoffeeType.textContent = order.cName;

        let pOrderDate = document.createElement('p');
        pOrderDate.className = "orderDate grid text-left";
        pOrderDate.textContent = order.dPurchase.substr(order.dPurchase,order.dPurchase.search(" ")+1);

        let pNetAmount = document.createElement('p');
        pNetAmount.className = "productPrice grid text-left";
        pNetAmount.textContent = order.nPrice + ' DKK';

        let pTax = document.createElement('p');
        pTax.className = "productTax grid text-left";
        pTax.textContent = order.nTax + ' DKK';

        let pTotal = document.createElement('p');
        pTotal.className = "orderTotal grid";
        pTotal.textContent = parseFloat(order.nTax + order.nNetAmount).toFixed(2) + ' DKK';

        grid.append(pOrderNo, pProductName, pCoffeeType, pOrderDate, pNetAmount, pTax, pTotal);

        let seeDetailsDiv = document.createElement('div');
        seeDetailsDiv.className = "pl-small align-items-center grid absolute see-details hide";

        let pSeeDetails = document.createElement('p');
        pSeeDetails.textContent = "See details";
        
        seeDetailsDiv.append(pSeeDetails);

        div.append(grid, seeDetailsDiv);

        ordersContainer.append(orderLink);
        
    });

    let orderButtons = document.querySelectorAll('.order-button');
    orderButtons.forEach(orderButton=>{
        const orderContent = orderButton.querySelector('.order');
        orderButton.addEventListener("mouseover", function(){
            orderButton.querySelector('.see-details').style.opacity = 1;
            orderContent.style.opacity = 0;
        });
    
        orderButton.addEventListener("mouseout", function(){
            orderButton.querySelector('.see-details').style.opacity = 0;
            orderContent.style.opacity = 1;
        });
    });
}


// EDIT, UPDATE, SAVE PROFILE

const inputName = document.querySelector("[name=inputName]");
const inputLastName = document.querySelector("[name=inputLastName]");
const inputEmail = document.querySelector("[name=inputEmail]");
const inputAddress = document.querySelector("[name=inputAddress]");
const inputPhoneNo = document.querySelector("[name=inputPhone]");
const inputCity = document.querySelector("[name=cityInput]");
const inputUsername = document.querySelector("[name=inputLoginName]");

    editButton.addEventListener('click', function(){
        event.preventDefault();
        
        inputName.classList.remove('not-input');
        inputLastName.classList.remove('not-input');
        inputEmail.classList.remove('not-input');
        inputAddress.classList.remove('not-input');
        inputPhoneNo.classList.remove('not-input');
        inputCity.classList.remove('not-input');
        inputUsername.classList.remove('not-input');

        inputName.disabled = false;
        inputLastName.disabled = false;
        inputEmail.disabled = false;
        inputAddress.disabled = false;
        inputPhoneNo.disabled = false;
        inputCity.disabled = false;
        inputUsername.disabled = false;
    
       
        showSaveButton();
    });


function showSaveButton(){
        document.querySelector('input').focus();
        saveButton.classList.remove('hide-button');
        saveButton.addEventListener('click', updateUser);   
        editButton.classList.add('hide-button');
}

function updateUser(){
    console.log('saved')
    event.preventDefault();
        
    let inputNameValue = inputName.value;
    let inputLastNameValue = inputLastName.value;
    let inputEmailValue = inputEmail.value;
    let inputAddressValue = inputAddress.value;
    let inputPhoneNoValue = inputPhoneNo.value;
    let inputCityValue = inputCity.value;
    let inputUsernameValue = inputUsername.value;

    let formData = new FormData();
    formData.append('inputName', inputNameValue);
    formData.append('inputLastName', inputLastNameValue);
    formData.append('inputEmail', inputEmailValue);
    formData.append('inputAddress', inputAddressValue);
    formData.append('inputPhone', inputPhoneNoValue);
    formData.append('cityInput', inputCityValue);
    formData.append('inputLoginName', inputUsernameValue);

    let endpoint = "api/api-update-profile.php";

    fetch(endpoint, {
    method: "POST",
    body: formData
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
    if (response == 1) {
        let text = "Your profile has been updated";
        let responseClass = "success";

        editButton.classList.remove('hide-button');
        saveButton.classList.add('hide-button');
     
        inputName.classList.add('not-input');
        inputLastName.classList.add('not-input');
        inputEmail.classList.add('not-input');
        inputAddress.classList.add('not-input');
        inputPhoneNo.classList.add('not-input');
        inputCity.classList.add('not-input');
        inputUsername.classList.add('not-input');

        showNotification(text, responseClass);
    }
    if (response == 0) {

        let text = "Something went wrong, please try again";
        let responseClass = "fail";
        
        showNotification(text, responseClass);
    }
    });
}

// NOTIFICATIONS



/////// DELETE FUNCTIONS

// BUTTONS

const deleteSubscriptionBtn = document.querySelectorAll(".current-subscriptions .button-delete");

deleteSubscriptionBtn.forEach(deleteBtn=>{
   
    deleteBtn.addEventListener("click", function(){
        let text = "Are you sure you want to delete subscription?";
        let deleteType = "subscription";
        let userSubscriptionID = deleteBtn.parentElement.parentElement.id;
        showModal(text, deleteType, userSubscriptionID);       
    });   
});

const deleteCardBtn = document.querySelector(".button-delete-card");

deleteCardBtn.addEventListener("click", function(){
    event.preventDefault();
    let text = "Are you sure you want to delete your credit card?";
    let deleteType = "creditcard";
    let creditCardID = document.querySelector('[name=userCreditCards]').value;
    showModal(text, deleteType, creditCardID);
    console.log(creditCardID);
});


const deleteProfileBtn = document.querySelector(".button-delete-profile");

deleteProfileBtn.addEventListener("click", function(){
    let text = "Are you sure you want to delete your profile?";
    let deleteType = "profile";
    let userID = "noID";
    showModal(text, deleteType, userID);
});


// MODAL 

function showModal(text, deleteType, itemID){

    console.log(itemID);

    let modal = document.createElement("div");
    modal.className = "modal";

    let modalContainer = document.createElement("div");
    modalContainer.className = "modalContainer grid grid-two p-medium";

    let h3 = document.createElement("h3");
    h3.textContent = text;

    let buttonAbort = document.createElement("button");
    buttonAbort.className = "button modal-button button-abort-delete";
    buttonAbort.textContent = "Cancel";

    let buttonDelete = document.createElement("button");
    buttonDelete.className = "button modal-button button-confirm-delete";
    buttonDelete.textContent = "Delete";

    modalContainer.append(h3, buttonDelete, buttonAbort);
    modal.append(modalContainer);
    document.querySelector('body').append(modal);

    document.querySelector(".button-abort-delete").addEventListener("click", function(){
        modal.classList.add('hide');
        setTimeout(function(){
            document.querySelector(".modal").remove();
        }, 1000);
    });

    document.querySelector(".button-confirm-delete").addEventListener("click", function(){
        if(deleteType == "subscription"){
            console.log("deleted subscription");
            console.log(itemID)
            deleteSubscription(itemID);
            modal.classList.add('hide');
            setTimeout(function(){
            document.querySelector(".modal").remove();
            }, 1000);
        }

        if(deleteType == "creditcard"){
            console.log("deleted creditcard");
            deleteCreditCard(itemID);

            modal.classList.add('hide');
            setTimeout(function(){
                document.querySelector(".modal").remove();
            }, 1000)
           
        }

        if(deleteType == "profile"){
            console.log("deleted user");

            deleteUser();

            modal.classList.add('hide');
            setTimeout(function(){
                document.querySelector(".modal").remove();
            }, 1000)
        }

        if(deleteType == "favorite"){
            console.log("deleted favorite");

            deleteFavorite(itemID);
            modal.classList.add('hide');
            setTimeout(function(){
            document.querySelector(".modal").remove();
            }, 1000);
        }
    });
}

function deleteSubscription(id){
    let endpoint = "api/api-delete-subscription.php"
    let formData = new FormData();
    formData.append('userSubscriptionID',id)
    fetch(endpoint, {
            method: "POST",
            body: formData
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
        if (response == 1) {
            let responseClass = "success";
            let text = "Your subscription has been cancelled";
            showNotification(text, responseClass);
            console.log(id);

            document.getElementById(id).remove();

            subscriptionItemsStatus = document.querySelector('.current-subscription').children.length;
            console.log(subscriptionItemsStatus);
            if(subscriptionItemsStatus == false){
                console.log('no subs');
                noSubscriptions();
            }
        }
        if (response == 0) {
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
        }
    });
}

function deleteCreditCard(id){
    let formData = new FormData();
    formData.append('nCreditCardID', id);
    let endpoint = "api/api-delete-creditcard.php";
        fetch(endpoint, {
            body: formData,
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
            if (response == 1) {
            let responseClass = "success";
            let text = "Your creditcard has been removed";
            showNotification(text, responseClass);

            document.getElementById(id).remove();
            }
            if (response == 0) {
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
            }
        });
}

function deleteUser(){
    let endpoint = "api/api-delete-user.php";
    console.log("user deleted");
    fetch(endpoint, {
            method: "POST"
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
        if(response == 1){
            let responseClass = "success";
            let text = "Your profile is deleted";
            showNotification(text, responseClass);

            setTimeout(function(){
                window.location.href = "delete";
            }, 1000);
            
        }
        if (response == 0) {   
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
        }
        
    });
}

function deleteFavorite(id){
    console.log('deleting favorite');
    let formData = new FormData();
    formData.append('productID', id);
    let endpoint = "api/api-unfavorite.php";
        fetch(endpoint, {
            body: formData,
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
            if (response == 1) {
            let responseClass = "success";
            let text = "The coffee has been deleted from your favorites";
            showNotification(text, responseClass);
            
            let itemToRemove = document.getElementById('favorite-'+id);
            itemToRemove.remove();

            favoritesStatus = document.querySelector('.current-favorites').children.length;
            console.log(favoritesStatus);

                if(favoritesStatus == 0){
                    console.log('no favs');
                    getPopularFavorites();
                    
                }
            }

            if (response == 0) {
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
            }
        });
}


function getPopularFavorites(){
    let endpoint = "api/api-get-popular-favorites.php";
    fetch(endpoint)
    .then(res => res.json())
    .then(response => {
        if(response == 0){
        let responseClass = "fail";
        let text = "Something went wrong, please try again";
        showNotification(text, responseClass);
        }
        else{
        showPopularFavorites(response);
                                    
        }
    });
}

function showPopularFavorites(favorites){
    console.log(favorites);

    headerForFavorites.remove();

    document.querySelector('.current-favorites').className = "current-favorites";
    
    let gridForBanner = document.createElement('div');
    gridForBanner.className = "grid grid-almost-two ph-xlarge";

    let textContainer = document.createElement('div');
    textContainer.className = "text-container grid align-items-center";
    let textContainerH3 = document.createElement('h3');
    textContainerH3.className = "text-left color-white pt-small align-self-bottom";
    textContainerH3.innerText = "You do not seem to have any favorites yet...";
    let textContainerH2 = document.createElement('h2');
    textContainerH2.className = "text-left coffee-type color-white align-self-top";
    textContainerH2.innerText = "Discover the most popular favorites";
    let textContainerImage = document.createElement('div');
    textContainerImage.className = "favorites-img image bg-contain";
    textContainerImage.style.backgroundImage = 'url(img/coffe1 (12).png)';

    textContainer.append(textContainerH3, textContainerH2);

    let containerBanner = document.createElement('div');
    containerBanner.className = "container-banner absolute mt-large bg-dark-brown";

    gridForBanner.append(textContainer, textContainerImage, containerBanner);

    let popularFavorites = document.createElement('div');
    popularFavorites.className = "popular-favorites grid grid-four m-medium";
  
    favorites.forEach(function(favorite) {
        console.log(favorite);

        let div = document.createElement('div');
        div.className = "product relative no-fav";
        div.setAttribute('id', 'favorite-'+favorite.nProductID);

        let h3Favorite = document.createElement('h3');
        h3Favorite.className = 'productName mt-small text-left';
        h3Favorite.textContent = favorite.cName;

        changeFormatForImg(favorite);
        let image = document.createElement('div');
        image.className = 'image bg-contain';
        image.style.backgroundImage = 'url(img/products/'+favorite.cName+'.png)';

        let description = document.createElement('div');
        description.className = 'description m-small';

        let pCoffeeType = document.createElement('p');
        pCoffeeType.className = 'productCoffeeType mt-small text-left';
        pCoffeeType.textContent = favorite.cCoffeeName;

        let h4Price = document.createElement('h4');
        h4Price.className = 'text-left mt-small productPrice';
        h4Price.textContent = favorite.nPrice+ ' DKK';

        description.append(h3Favorite, pCoffeeType, h4Price);

        let buttonAddToCart = document.createElement('button');
        buttonAddToCart.className = "addProdToCartBtn button";
        buttonAddToCart.innerText = "Add to cart";

        let buttonLearnMore = document.createElement('a');
        buttonLearnMore.className = "button viewMoreBtn";
        buttonLearnMore.setAttribute('href', 'singleProduct?id='+favorite.nProductID);

        div.append(image, description, buttonAddToCart, buttonLearnMore);

        popularFavorites.append(div);
    });

    document.querySelector('.current-favorites').append(gridForBanner);
    document.querySelector('.current-favorites').append(popularFavorites);

}

// ADD CREDITCARD

const addCreditCardForm = document.querySelector("#form-creditcard");
const saveCreditCardButton = addCreditCardForm.querySelector(".button-save");
    

    saveCreditCardButton.addEventListener('click', function(){
        event.preventDefault();
        
        let IBAN = document.querySelector("[name=inputIBAN]").value;
        let CCV = document.querySelector("[name=inputCCV]").value;
        let expiration = document.querySelector("[name=inputExpiration]").value;

        let formData = new FormData();
        formData.append('inputIBAN', IBAN);
        formData.append('inputCCV', CCV);
        formData.append('inputExpiration', expiration);

        let endpoint = "api/api-create-creditcard.php";

        fetch(endpoint, {
            method: "POST",
            body: formData
          })
            .then(res => res.text())
            .then(response => {

            if(response == 0){
                    let text = "Something went wrong, please try again";
                    let responseClass = "fail";
                    
                    showNotification(text, responseClass);
            }

              if (response) {

                let text = "Your creditcard has been added";
                let responseClass = "success";

                showNotification(text, responseClass);

                document.querySelectorAll("#form-creditcard input").forEach(input=>{
                    input.value = "";
                    input.classList.remove('valid');

                })

                if(document.querySelector('.no-creds') != null){
                        document.querySelector('.no-creds').remove();
                }

                let creditCardContainer = document.createElement("option");
                creditCardContainer.setAttribute("id", response);
                creditCardContainer.value = response;
                creditCardContainer.innerText = IBAN;

                document.querySelector("[name=userCreditCards]").appendChild(creditCardContainer);
            
            }
        });
    });

// CHECK IF USER HAS SUBSCRIPTIONS

const currentSubscriptions = document.querySelector('.current-subscription');
let subscriptionItemsStatus = currentSubscriptions.children.length; 

console.log(subscriptionItemsStatus);

const currentSubscriptionsParent = currentSubscriptions.parentElement;

if(subscriptionItemsStatus == 0){
    noSubscriptions();
}

function noSubscriptions(){

        let h2Header = currentSubscriptionsParent.querySelector('h2');
        h2Header.className = 'text-center mb-small';
        h2Header.innerText = 'Get quality coffee right to your doorstep';
        let h3SubHeader = document.createElement('h3');
        h3SubHeader.innerText = 'Discover our delicious and convenient coffee subscriptions';
        h2Header.after(h3SubHeader);

        getAllSubscriptionsAsJson();
        
        // SUBSCRIPTIONS FUNCTION
        function getAllSubscriptionsAsJson() {
            let endpoint = "api/api-get-subscriptions.php";
            return new Promise((resolve, reject) => {
              fetch(endpoint)
                .then(res => res.json())
                .then(function(subscriptions) {
                  resolve(subscriptions);
        
                  showAllSubscriptions(subscriptions);
                });
            });
          }
        
        function showAllSubscriptions(subscriptions){
            subscriptions.forEach(function(subscription) {
        
            let subscriptionItem = document.createElement('div');
            subscriptionItem.className = 'subscriptionItem no-sub';
            subscriptionItem.setAttribute('id', subscription.nProductID);
        
            let subscriptionItemBg = document.createElement('div');
            subscriptionItemBg.className = 'subscriptionItemBg';
        
            let img = document.createElement('img');
            changeFormatForImg(subscription);
            img.src = "img/products/" + subscription.cName + ".png";
        
            let h3Name = document.createElement('h3');
            h3Name.className = 'subscriptionName';
            h3Name.innerText = subscription.cSubscriptionName;
        
            let h4Price = document.createElement('h4');
            h4Price.className = 'priceSubscription';
            h4Price.innerText = subscription.nPrice + ' DKK / Month';
        
            let whiteBg = document.createElement('div');
            whiteBg.className = 'white-text-bg';
        
            let pOrigin = document.createElement('p');
            pOrigin.className = 'productCoffeeType pb-small text-center';
            pOrigin.innerText = subscription.cCoffeeName;
        
            let pDesc = document.createElement('p');
            pDesc.className = 'descSubscription ph-small';
            pDesc.innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis quasi provident nulla minus odit architecto.';
        
            let addSubToCartBtn = document.createElement('button');
            addSubToCartBtn.className = 'addSubToCartBtn button';
            addSubToCartBtn.innerText = 'Add to Cart';
        
            subscriptionItemBg.append(img, h3Name, h4Price);
            whiteBg.append(pOrigin, pDesc);
        
            subscriptionItem.append(subscriptionItemBg, whiteBg, addSubToCartBtn);
        
            currentSubscriptions.append(subscriptionItem);
            });
        }
}

