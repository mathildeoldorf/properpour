<?php
$sTitle = ' | Thank you for your visit'; // Add the product dynamically
$sCurrentPage = 'Thank you';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="delete log-out thank-you">
<section class="section-three mb-large ph-large pt-medium">
      <div class="related-products relative">
      <h1 class="text-center p-small">Thank you for using Proper Pour</h1>
      <h3 class="text-center pt-small mb-medium">We hope to see you again some day!</h3>

    <h2 class="coffee-type mb-small">Want to browse our newest products?</h2>
    <h3 class="coffee-type mb-medium">Visit the shop and discover a world of quality coffee</h3>
        <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
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

      echo 
      ' <a href="singleProduct?id='.$jProduct['nProductID'].'">
           <div class="product" id="product-'.$jProduct['nProductID'].'">
               <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
               <div class="description m-small">
                   <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
                   <h4 class="productName mt-small text-left">'.$jProduct['cName'].'</h4>
                   <h4 class="productPrice mt-small">'.$jProduct['nPrice'].' DKK</h4>
               </div>
           </div>
       </a>';
    }
}

?>
</main>
<?php
$sScriptPath ="sessionStorageCart.js";
$connection = null;
require_once(__DIR__ . '/components/footer.php');
