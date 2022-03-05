<?php

$sTitle = '| Order summary';
$sCurrentPage = 'profile';

require_once(__DIR__ . '/components/header.php');

if (!$_SESSION) {
    header('Location: log-in');
    exit;
  }

  if ($_SESSION) {

    $jLoggedUser = $_SESSION['user'];
    $nUserID = $jLoggedUser['nUserID'];

    if (isset($jLoggedUser['dDeleteUser'])) {
        header('Location: log-in');
        exit;
    }

    $iProductID = $_GET['id'];
    require_once(__DIR__ . '/connection.php');
    require_once(__DIR__ . '/components/functions.php');

    $sqlOrder = "SELECT tpurchase.nPurchaseID, tpurchase.dPurchase, tpurchase.nNetAmount, tpurchase.nTax, 
    tproduct.cName AS cProductName, tproduct.nPrice, 
    tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
    FROM tpurchase INNER JOIN tproduct ON tpurchase.nProductID = tproduct.nProductID
    INNER JOIN tcreditcard ON tpurchase.nCreditCardID = tcreditcard.nCreditCardID
    INNER JOIN tuser ON tcreditcard.nUserID = tuser.nUserID
    INNER JOIN tcoffeetype on tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID WHERE tpurchase.nPurchaseID = :id";

    $statementOrder = $connection->prepare($sqlOrder);

    $data =[
        ':id' => $iProductID
        ];

    if ($statementOrder->execute($data)) {
        $order = $statementOrder->fetch(PDO::FETCH_ASSOC);
        $connection = null;

        $nCoffeeTypeID = $order['nCoffeeTypeID'];

        $imgUrl = $order['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));

        $sTitle = '| Order: '.$imgUrl; // Add the product dynamically
        $sCurrentPage = 'profile';

        require_once(__DIR__ . '/components/header.php');?>

<main class="single-order mv-medium">
<button class="back-button absolute">&lt;</button>

    <section class="section-one mb-footer ph-large grid relative related-products">    
    
    <section class="order-summary">
    <div class="order-details p-medium" id="<?= $order['nPurchaseID'] ;?>">
    <h1 class="cart-header text-left p-medium">Order summary</h1>
        <div class="grid grid-five pl-small ml-small">
            <h4 class="cart-header text-left">Order no.</h4>
            <p class="cart-header text-left mb-small"><?= $order['nPurchaseID'] ;?></p>
        </div>
        <div class="grid grid-five pl-small ml-small">
            <h4 class="cart-header text-left">Purchase date</h4>
            <p class="cart-header text-left mb-small"><?= $order['dPurchase'] ;?></p>
        </div>
        <div id="paymentOverview" class="orderDiv grid">
            
            <p class="bold">Description</p>
            <p class="bold">Price</p>
            <p class="bold">Quantity</p>
            <div class="frmLine"></div>
            <div class="grid grid-one">
              <h3 class="title_cart bold uppercase mb-small" name="coffeeName"><?= $imgUrl ;?></h3>
              <div class="grid grid-two-thirds">
                <img class="img_cart align-self-center justify-self-start" src="img/products/<?= $result;?>.png"/>
                <div class="grid">
                    <p class="type_cart pb-small align-self-bottom"><?= $order['cName'] ;?></p>
                    <p class="type_cart_grind pb-small align-self-end">Grind</p>
                </div>
              </div>
            </div>
            <p class="price_cart"><?= $order['nPrice'] ;?></p>
            
            <input type="number" min="0" class="cart_quantity no-input" readonly value="1">
        </div>
        <div class="grid grid-three">
            <div class="order-amount grid">
                <h2 class="text-left mb-small">Amount paid</h2>
                <div class="grid grid-two">
                    <h4 class="align-self-bottom text-left">Subtotal</h4>
                    <p class="netamount_cart text-right"><?= $order['nNetAmount'] ;?> DKK</p>
                    <h4 class="align-self-bottom text-left">Tax</h4>
                    <p class="tax_cart text-right"><?= $order['nTax'] ;?> DKK</p>
                </div>
                <h3 class="align-self-bottom text-right mt-small">Total amount</h3>
                <h4 id="totalsum" class="text-right align-self-top"><?= $order['nTax'] + $order['nNetAmount'] ;?> DKK</h4>
            </div>
        </div>
    </div>
  
    </section>
    <div class="container-banner absolute pv-large bg-light-brown"></div>
</section>

     
<?php

    }
}?>
   
</main>

<?php
require_once(__DIR__ . '/components/footer.php');