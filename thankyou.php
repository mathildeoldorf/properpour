<?php
$sTitle = ' | Thank you'; // Add the product dynamically
$sCurrentPage = 'Thank you';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="thank-you">
<div class="p-medium bg-dark-brown color-white mb-medium">
<h1 class="text-center pt-small">Thank you for choosing us</h1>
<!-- <h2 class="mb-small">The Proper Pour</h2> -->
    <p class="text-center pt-small mb-small pb-small">Your coffee is on it's way to your door step</p>
    <h3 class="text-center pt-small color-white uppercase">Estimated delivery</h3>
    <p class="text-center pb-small">Tomorrow</p>
    <!-- <p class="text-center pt-small pb-small">Find this receipt under Profile > Orders.</p> -->
</div>
<section class="section-three mb-footer ph-large">
    <div class="related-products relative">

<section class="order-summary">
    <div class="order-details p-medium">
    <h1 class="cart-header text-left p-medium">Order summary</h1>
        <div class="grid grid-five pl-small ml-small">
            <h4 class="cart-header text-left">Order no.</h4>
            <p class="cart-header text-left mb-small">135</p>
        </div>
        <div class="grid grid-five pl-small ml-small">
            <h4 class="cart-header text-left">Purchase date</h4>
            <p class="cart-header date text-left mb-small"></p>
        </div>
        <div id="paymentOverview" class="orderDiv grid">
            
            <p class="bold">Description</p>
            <p class="bold">Price</p>
            <p class="bold">Quantity</p>
            <div class="frmLine"></div>
            <div class="grid grid-one">
              <h3 class="title_cart bold uppercase mb-small productName" name="coffeeName"></h3>
              <div class="grid grid-two-thirds">
                <img class="productImg align-self-center justify-self-start" src=""/>
                <div class="grid">
                    <p class="coffeeType pb-small align-self-bottom"></p>
                    <p class="type_cart_grind pb-small align-self-end">Grind</p>
                </div>
              </div>
            </div>
            <p class="price_cart"></p>
            
            <input type="number" min="0" class="no-input" readonly value="1">
        </div>
        <div class="grid grid-three">
            <div class="order-amount grid">
                <h2 class="text-left mb-small">Amount paid</h2>
                <div class="grid grid-two">
                    <h4 class="align-self-bottom text-left">Subtotal</h4>
                    <p class="netamount_cart text-right"> DKK</p>
                    <h4 class="align-self-bottom text-left">Tax</h4>
                    <p class="tax_cart text-right"></p>
                </div>
                <h3 class="align-self-bottom text-right mt-small">Total amount</h3>
                <h4 id="totalsum" class="text-right align-self-top amountPayed"></h4>
            </div>
        </div>
    </div>
    </section>


<div class="container-banner absolute pv-large bg-light-brown"></div>
<div class="products-container grid grid-four">
<?php
$sqlProducts = "SELECT tproduct.nProductID, tproduct.cName AS cProductName, 
tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
FROM tproduct INNER JOIN tcoffeetype on tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID WHERE tproduct.bActive != 0 LIMIT 4";
$statementProducts = $connection->prepare($sqlProducts);

if ($statementProducts->execute()) {
    $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($jProducts as $jProduct) {
      $imgUrl = $jProduct['cProductName'];
      $result = strtolower(str_replace(" ", "-", $imgUrl));

    //   echo 
    //   ' <a href="singleProduct?id='.$jProduct['nProductID'].'">
    //        <div class="product" id="product-'.$jProduct['nProductID'].'">
    //            <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
    //            <div class="description m-small">
    //                <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
    //                <h4 class="productName mt-small text-left">'.$jProduct['cName'].'</h4>
    //                <h4 class="productPrice mt-small">'.$jProduct['nPrice'].' DKK</h4>
    //            </div>
    //        </div>
    //    </a>';
    }
}

?>
        </div>
      </div>
<script src="js/thankyou.js"></script>
</main>
<?php
$sScriptPath ="sessionStorageCart.js";
$connection = null;
require_once(__DIR__ . '/components/footer.php');
