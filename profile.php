<?php
$sTitle = '| Profile ';
$sCurrentPage = 'profile';

require_once(__DIR__ . '/components/header.php');

if (!$_SESSION) {
  header('Location: log-in');
  exit;
}

if ($_SESSION) {

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/functions.php');

$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];

$_SESSION['productID'] = false;

  if (isset($jLoggedUser['dDeleteUser'])) {
    header('Location: log-in');
    exit;
  }

  // PRODUCTS
  $sqlProducts = "SELECT tproduct.nProductID, tproduct.cName AS cProductName, 
                tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
                tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                FROM tproduct 
                INNER JOIN tcoffeetype 
                  ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                WHERE tproduct.bActive != 0 
                LIMIT 4";
  $statementProducts = $connection->prepare($sqlProducts);

  // PICK A RANDOM FAVORITE
  $sqlRandomFavorite = "SELECT tcoffeetype.nCoffeeTypeID, tproduct.cName 
                        FROM tcoffeetype
                        INNER JOIN tproduct
                        ON tcoffeetype.nCoffeeTypeID = tproduct.nCoffeeTypeID
                        INNER JOIN tfavorite
                        ON tproduct.nProductID = tfavorite.nProductID
                        WHERE tfavorite.nUserID = :id AND tfavorite.bActive = 1 AND tproduct.bActive = 1";
  $statementRandomFavorite = $connection->prepare($sqlRandomFavorite);

  // RELATED PRODUCTS BASED ON RANDOM FAVORITE
  $sqlRelatedProducts = "SELECT tproduct.nProductID, tproduct.cName AS cProductName, 
                          tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
                          tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                          FROM tproduct
                          INNER JOIN tcoffeetype
                          ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
                          WHERE tproduct.nProductID NOT IN (  SELECT nProductID
                                                              FROM tfavorite
                                                              WHERE nUserID = :id
                                                            AND tfavorite.bActive = 1)
                          AND tcoffeetype.nCoffeeTypeID = :coffeeid
                          AND tproduct.bActive = 1";

  $statementRelatedProducts = $connection->prepare($sqlRelatedProducts);

  // ALL SUBSCRIPTIONS LIMIT 3
  $sqlSubscriptions = "SELECT tsubscriptiontype.nSubscriptionTypeID, tsubscriptiontype.cName AS cSubscriptionName,
                      tproduct.nProductID, tproduct.cName AS cProductName, tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
                      tcoffeetype.nCoffeeTypeID, tcoffeetype.cName  
                      FROM tsubscriptiontype 
                      INNER JOIN tproduct 
                        ON tsubscriptiontype.nProductID = tproduct.nProductID 
                      INNER JOIN tcoffeetype 
                        ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                      WHERE tproduct.bActive != 0 
                      LIMIT 3";
  
  $statementSubscriptions = $connection->prepare($sqlSubscriptions);

  // THE USER'S SUBSCRIPTIONS
  $sqlUserSubscription = "SELECT tusersubscription.nUserSubscriptionID, tusersubscription.dCancellation, 
                        tsubscriptiontype.nSubscriptionTypeID, tsubscriptiontype.cName AS cSubscriptionName,
                        tproduct.nProductID, tproduct.cName AS cProductName, tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
                        tcoffeetype.nCoffeeTypeID, tcoffeetype.cName  
                        FROM tUser
                        INNER JOIN tusersubscription 
                          ON tuser.nUserID = tusersubscription.nUserID 
                        INNER JOIN tsubscriptiontype 
                          ON tusersubscription.nSubscriptionTypeID = tsubscriptiontype.nSubscriptionTypeID 
                        INNER JOIN tproduct 
                          ON tsubscriptionType.nProductID = tproduct.nProductID 
                        INNER JOIN tcoffeeType 
                          ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                        WHERE tuser.nUserID = :id AND tusersubscription.dCancellation IS NULL AND tproduct.bActive != 0";

  $statementUserSubscription = $connection->prepare($sqlUserSubscription);

  // THE USER'S CREDITCARDS
  $sqlCreditCard = "SELECT * FROM tcreditcard WHERE tcreditcard.nUserID = :id AND dDeleteCreditCard IS NULL";
  $statementCreditCard = $connection->prepare($sqlCreditCard);

  // THE USER'S ORDERS
  $sqlOrders = "SELECT tpurchase.nPurchaseID, tpurchase.nProductID, tpurchase.dPurchase, tpurchase.nNetAmount, tpurchase.nTax, 
                tproduct.cName AS cProductName, tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
                tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                FROM tpurchase
                INNER JOIN tproduct 
                  ON tpurchase.nProductID = tproduct.nProductID
                INNER JOIN tcreditcard 
                  ON tpurchase.nCreditCardID = tcreditcard.nCreditCardID
                INNER JOIN tuser 
                  ON tcreditcard.nUserID = tuser.nUserID
                INNER JOIN tcoffeetype 
                  ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
                WHERE tuser.nUserID = :id 
                ORDER BY tpurchase.nPurchaseID DESC
                LIMIT 5";

  $statementOrders = $connection->prepare($sqlOrders);

  ?>

  <main class="profile mb-footer">
  <div class="container-banner mb-medium p-small ph-xlarge bg-light-brown">
            <div class="content-container grid grid-two-thirds-reversed relative">
                <div class="container-header align-items-center color-white">
                    <h1>Welcome to your profile <?= $jLoggedUser['cName']; ?></h1>
                    <!-- <p class="text-left color-white">Discover your profile</p> -->
                    <!-- <p class="banner-message mt-small">
                        Discover your personalized profile from where you can discover a world of quality coffee
                    </p> -->
                </div>
                <div class="image bg-contain absolute"></div>
            </div>
        </div>
  <!-- <h1 class="text-center pv-small mt-small ph-medium"></h1>-->
  <!-- <h3 class="text-center uppercase pb-small mb-small ph-medium">Your profile </h3>  -->


  <section class="profile-options grid grid-five ph-medium">
    <button class="profile-info">Profile Details</button>
    <button class="payment-info">Payment details</button>
    <button class="subscriptions-info">Subscriptions</button>
    <button class="order-info">Orders</button>
    <button class="favoritesButton">Favorites</button>
  </section>

    <section class="section-one grid mt-medium ph-medium hide">
    
      <div class="profile-info-container grid mh-xlarge hide">
          <form id="form-profile" class="grid" method="post">
          
          <div class="form-profile-form-container-info grid bg-grey pv-medium ph-medium">
          <h2 class="text-left">Profile details</h2>
        <label id="cName" class="grid grid-almost-two-reversed pb-small mt-small" for="name">
              <p class="text-left align-self-center">Name</p>
              <input disabled class=" not-input" data-type="string" data-min="2" data-max="20" type="text" data-type="string" name="inputName" placeholder="First name" value="<?= $jLoggedUser['cName']; ?>">
              <h5 class="light">Must be 1 to 20 characters</h5>
            </label>

            <label id="cSurname" class="grid grid-almost-two-reversed pb-small" for="lastName">
              <p class="text-left align-self-center">Last Name</p>
              <input disabled class="  not-input" data-type="string" data-min="2" data-max="20" type="text" name="inputLastName" placeholder="Last name" value="<?= $jLoggedUser['cSurname']; ?>">
              <h5 class="light">Must be 1 to 20 characters</h5>
            </label>

            <label class="grid grid-almost-two-reversed pb-small" for="loginName">
              <p class="text-left align-self-center">Username</p>
              <input disabled class=" not-input" type="text" data-type="string" data-min="2" data-max="255" name="inputLoginName" placeholder="username" value="<?= $jLoggedUser['cUsername']; ?>">
              <h5 class="light">Must be at least 2 characters</h5>
            </label>

            <label id="cEmail" class="grid grid-almost-two-reversed pb-small" for="email">
              <p class="text-left align-self-center">Email</p>
              <input disabled class=" not-input" type="email" data-type="email" name="inputEmail" placeholder="email" value="<?= $jLoggedUser['cEmail']; ?>">
              <h5 class="light">Must be a valid email address</h5>
            </label>
              <label id="nCityID" for="cityInput" class="grid grid-almost-two-reversed pb-small">
              <p class="text-left align-self-center">City</p>
              <select disabled class=" not-input" data-type="integer" data-min="0" data-max="999" name="cityInput" value="<?= $jLoggedUser['nCityID'] ;?>">
                <option value="1" <?php if ($jLoggedUser['nCityID'] == 1) echo 'selected' ?>>Copenhagen</option>
                <option value="2" <?php if ($jLoggedUser['nCityID'] == 2) echo 'selected' ?>>Århus</option>
                <option value="3" <?php if ($jLoggedUser['nCityID'] == 3) echo 'selected' ?>>Odense</option>
                <option value="4" <?php if ($jLoggedUser['nCityID'] == 4) echo 'selected' ?>>Roskilde</option>
                <option value="5" <?php if ($jLoggedUser['nCityID'] == 5) echo 'selected' ?>>Lyngby</option>
                <option value="6" <?php if ($jLoggedUser['nCityID'] == 6) echo 'selected' ?>>Aalborg</option>
                <option value="7" <?php if ($jLoggedUser['nCityID'] == 7) echo 'selected' ?>>Silkeborg</option>
                <option value="8" <?php if ($jLoggedUser['nCityID'] == 8) echo 'selected' ?>>Ballerup</option>
                <option value="9" <?php if ($jLoggedUser['nCityID'] == 9) echo 'selected' ?>>Hellerup</option>
                <option value="10" <?php if ($jLoggedUser['nCityID'] == 10) echo 'selected' ?>>Holte</option>
                <option value="11" <?php if ($jLoggedUser['nCityID'] == 11) echo 'selected' ?>>Horsens</option>
                <option value="12" <?php if ($jLoggedUser['nCityID'] == 12) echo 'selected' ?>>Randers</option>
                <option value="13" <?php if ($jLoggedUser['nCityID'] == 13) echo 'selected' ?>>Sønderborg</option>
                <option value="14" <?php if ($jLoggedUser['nCityID'] == 14) echo 'selected' ?>>Helsingør</option>
                <option value="15" <?php if ($jLoggedUser['nCityID'] == 15) echo 'selected' ?>>Dragør</option>
                <option value="16" <?php if ($jLoggedUser['nCityID'] == 16) echo 'selected' ?>>Charlottenlund</option>
                <option value="17" <?php if ($jLoggedUser['nCityID'] == 17) echo 'selected' ?>>Frederiksberg</option>
                <option value="18" <?php if ($jLoggedUser['nCityID'] == 18) echo 'selected' ?>>Valby</option>
                <option value="19" <?php if ($jLoggedUser['nCityID'] == 19) echo 'selected' ?>>Whateverby</option>
                <option value="20" <?php if ($jLoggedUser['nCityID'] == 20) echo 'selected' ?>>Herlev</option>
                <option value="21" <?php if ($jLoggedUser['nCityID'] == 21) echo 'selected' ?>>Vanløse</option>
              </select>
              <h5 class="light">Choose your city</h5>
            </label>
            <label id="cAddress" class="grid grid-almost-two-reversed pb-small" for="userAddress">
              <p class="text-left align-self-center">Address</p>    
              <input disabled class=" not-input" type="text" data-type="string" data-min="12" data-max="9999999999" name="inputAddress" placeholder="Address" value="<?= $jLoggedUser['cAddress']; ?>">
              <h5 class="light">Must be 12+ characters</h5>
            </label>

            <label id="cPhoneNo" class="grid grid-almost-two-reversed pb-small" for="userPhone">
              <p class="text-left align-self-center">Phone</p>        
              <input disabled class="phone not-input" type="number" data-type="number" data-min="9999999" data-max="99999999" name="inputPhone" placeholder="phone number" value="<?= $jLoggedUser['cPhoneNo']; ?>">
              <h5 class="light">Must be 8 characters</h5>
            </label>
            <div class="formButtonContainer">
                <button class="button-edit button">Edit information</button>
                <button class="button-save formBtn hide-button button">Save information</button>
            </div>
          </form>
        </div>
      </div>

        <!-- END OF PROFILE FORM -->

        <div class="form-profile-form-container-creditcard grid bg-grey pv-medium ph-medium hide">
        <h2 class="text-left">Payment details</h2>
          <div class="mt-small">
          <form method="POST" id="savedCardFrm" class="choose-credit-card  grid grid-two-thirds-reversed">

          <?php
            if ($statementCreditCard->execute([':id' => $nUserID])) {
              $jUserCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);?>

              <label class=" align-self-center"><p class="text-left pb-small">Your credit cards</p>
                <select  name="userCreditCards" id="">
              <?php
              if (count($jUserCreditCards) == 0) {?>

                  <option class="no-creds" value="">
                    Please add a credit card
                  </option>
              
              <?php
              }
              if (count($jUserCreditCards) >= 1) {
                foreach ($jUserCreditCards as $jUserCreditCard) {
                  $nCreditCardID = $jUserCreditCard['nCreditCardID'];?>

                <option id="<?= $jUserCreditCard['nCreditCardID'];?>" value="<?= $jUserCreditCard['nCreditCardID'];?>"> <?= $jUserCreditCard['cIBAN'];?>
                </option>       
                <?php
                }
              }
            } ?>

                </select>
              </label>
              <button class="button-delete-card button align-self-bottom">Delete</button>
          </form>
          </div>

          <form id="form-creditcard" method="post">
            <p class="addCardHeader text-left pb-small mt-medium">Add creditcard</p>
            <label class="grid grid-two-thirds" for="inputIBAN">
              <p class="text-left align-self-center">IBAN</p><h5 class="light text-right">Must be 18 digits</h5>
              <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="number" required data-type="string" name="inputIBAN" value="">    
            </label>
              <label class="grid grid-two-thirds" for="inputCCV">
                <p class="text-left align-self-center">CCV</p><h5 class="light text-right">Must be 3 digits</h5>
                <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="number" name="inputCCV" required>
                
              </label>
              <label class="grid grid-two-thirds" for="inputExpiration">
                <p class="text-left align-self-center">Expiration date</p> <h5 class="light text-right">Must be 4 digits</h5>
                <input class="mb-small" data-type="integer" data-min="100" data-max="1999" type="number" name="inputExpiration" required> 
              </label>
              <button class="button-save formBtn button " disabled>Save creditcard</button>
            </form>
          </div>

          <div class="orders-container grid hide">
            <h2 class="mb-medium text-left">Orders</h2>
            <div class="pl-small mh-medium ph-medium orders-headers relative grid grid-seven bg-brown color-white">
              <p class="grid text-left pr-small">Order no.</p>
              <p class="grid text-left">Product</p>
              <p class="grid text-left">CoffeeType</p>
              <p class="grid text-left">Purchase date</p>
              <p class="grid text-left">Net amount</p>
              <p class="grid text-left">Tax</p>
              <p class="grid text-right">Total amount</p>
            </div>

    <?php
    if ($statementOrders->execute([':id' => $nUserID])) {

      $orders = $statementOrders->fetchAll(PDO::FETCH_ASSOC);

      foreach ($orders as $order) {

        $arrayTotal = array($order['nNetAmount'], $order['nTax']);

        $imgUrl = $order['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
        echo 
        '<a class="order-button mh-medium" href="singleOrder?id='.$order['nPurchaseID'].'">
          <div class="relative">
            <div class="pl-small align-items-center absolute product order relative grid grid-seven" id="order-'.$order['nPurchaseID'].'">
                    <p class="orderNo grid text-left">'.$order['nPurchaseID'].'</p>
                    <p class="productName grid text-left">'.$order['cProductName'].'</p>
                    <p class="productCoffeeType grid text-left">'.$order['cName'].'</p>
                    <p class="orderDate grid text-left">'.substr($order['dPurchase'], 0,strpos($order['dPurchase'], ' ')).'</p>
                    <p class="productPrice grid text-left">'.$order['nNetAmount'].' DKK</p>
                    <p class="productTax grid text-left">'.$order['nTax'].' DKK</p>
                    <p class="orderTotal grid">'.array_sum($arrayTotal).' DKK</p>
            </div>
            <div class="pl-small align-items-center grid absolute see-details hide"> 
              <p>See order details</p>
            </div>
          </div>
        </a>'; 
      }
    }; ?>
<!-- <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div> -->
      <button class="button grid justify-self-center mt-small loadAllOrders">See all</button>
      </div>
    </section>

    <section class="section-three favorites mv-medium ph-medium mb-large hide">
      <div class="current-favorites containerForFavorites grid grid-four m-medium">
      </div>
    </section>
    

    <section class="section-two mv-medium ph-medium current-subscriptions hide">
      <h2 class=" text-left mb-medium">Your current subscriptions</h2>
      <div class="current-subscription containerForSubscriptions  grid grid-three m-medium">
        <?php
          if ($statementUserSubscription->execute([':id' => $nUserID])) {
            $jUserSubscriptions = $statementUserSubscription->fetchAll(PDO::FETCH_ASSOC);
           
            if (count($jUserSubscriptions) >= 1) {?>

            <?php

              foreach ($jUserSubscriptions as $jUserSubscription) {
                $nProductID = $jUserSubscription['nProductID'];
                $nCoffeeTypeID = $jUserSubscription['nCoffeeTypeID'];
                $nSubscriptionTypeID = $jUserSubscription['nSubscriptionTypeID'];
                $imgUrl = $jUserSubscription['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl)); ?>

              <div class="subscriptionItem" id="<?= $jUserSubscription['nUserSubscriptionID']; ?>">
                <div class="subscriptionItemBg">
                  <img src="img/products/<?= $result; ?>.png" alt="">
                  <h3 class="subscriptionName"><?= $jUserSubscription['cSubscriptionName']; ?></h3>
                  <h4 class="priceSubscription"><?= $jUserSubscription['nPrice']; ?> DKK / Month</h4>
                </div>
                <div class="white-text-bg">
                  <p class="mb-small text-center"><?= $jUserSubscription['cName']; ?></p>
                  <button class="button button-delete">Delete</button>
                </div>
              </div>

        <?php
              }
            }
          }
          ?>
      </div>
    </section>

    <section class="section-four ph-large mb-footer mt-medium">
      <h2 class="mb-small">Want to try something new?</h2>
      <h3 class="mb-small">Visit the shop and explore a world of quality coffee</h3>
      <div class="related-products relative">
        <div class="container-banner absolute pv-large bg-dark-brown"></div>
        <div class="products-container grid grid-four">

          <?php

            if ($statementProducts->execute()) {

              $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);

              foreach ($jProducts as $jProduct) {

                $imgUrl = $jProduct['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
                echo 
                ' <div class="product relative" id="' . $jProduct['nProductID'] . '">
                <div class="image bg-contain" style="background-image: url(img/products/' . $result . '.png)"></div>
                <div class="description m-small">
                    <h3 class="productName mt-small text-left">' . $jProduct['cProductName'] . '</h3>
                    <p class="productCoffeeType mt-small text-left">' . $jProduct['cName'] . '</p>
                <h4 class="text-left mt-small productPrice">' . $jProduct['nPrice'] . ' DKK</h4>
                </div>
                <button class="addProdToCartBtn button">Add to Cart</button>
                <a class="button viewMoreBtn" href="singleProduct?id=' . $jProduct['nProductID'] . '">Learn more</a>
            </div>'; 
              }
            }; ?>
        </div>
      </div>



  </div>
  </div>
  </section>

  <?php

if ($statementRandomFavorite->execute([':id' => $nUserID])) {

  $results = $statementRandomFavorite->fetchAll(PDO::FETCH_ASSOC);

  if(!empty($results)){
  $array_CoffeeID = []; 
  $array_Names = [];

  foreach($results as $result){
    $coffeeType = $result['nCoffeeTypeID'];
    $name = $result['cName'];

    array_push($array_CoffeeID, $coffeeType);
    array_push($array_Names, $name);
  }

  $coffeePicker = array_rand($array_CoffeeID);
  $randomCoffeeType = $array_CoffeeID[$coffeePicker];
  ?>

  <section class="section-five ph-large mb-footer mt-medium">
      <h2 class="mb-small">Because you like <?= $array_Names[$coffeePicker] ?></h2>
      <h3 class="mb-small">Visit the shop and explore a world of quality coffee</h3>
      <div class="related-products relative">
        <div class="container-banner absolute pv-large bg-light-brown"></div>
        <div class="products-container grid grid-four">

          <?php

              if ($statementRelatedProducts->execute([':id' => $nUserID, ':coffeeid' => $randomCoffeeType])) {

              $jRelatedProducts = $statementRelatedProducts->fetchAll(PDO::FETCH_ASSOC);

              foreach ($jRelatedProducts as $jRelatedProduct) {

                $imgUrl = $jRelatedProduct['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
                echo 
                ' <div class="product relative" id="' . $jRelatedProduct['nProductID'] . '">
                <div class="image bg-contain" style="background-image: url(img/products/' . $result . '.png)"></div>
                <div class="description m-small">
                    <h3 class="productName mt-small text-left">' . $jRelatedProduct['cProductName'] . '</h3>
                    <p class="productCoffeeType mt-small text-left">' . $jRelatedProduct['cName'] . '</p>
                <h4 class="text-left mt-small productPrice">' . $jRelatedProduct['nPrice'] . ' DKK</h4>
                </div>
                <button class="addProdToCartBtn button">Add to Cart</button>
                <a class="button viewMoreBtn" href="singleProduct?id=' . $jRelatedProduct['nProductID'] . '">Learn more</a>
            </div>'; 
              }
            }

  }
  }
?>
        </div>
      </div>
<?php
          $connection = null;
}
?>

  </div>
  </div>
  </section>
  
  <button class="button button-delete-profile mb-large">Delete Profile</button>
  </main>
  <script src="js/validation.js"></script>
  <script src="js/sessionStorageCart.js"></script>

  <?php
  $sScriptPath = 'profile.js';
  require_once(__DIR__ . '/components/footer.php');
