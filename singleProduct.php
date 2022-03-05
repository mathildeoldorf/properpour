<?php

$iProductID = $_GET['id'];

require_once(__DIR__ . '/connection.php');

$sqlSingleProduct = "SELECT tproduct.nProductID, tproduct.cName as cProductName, tproduct.nCoffeeTypeID as nProductCoffeeTypeID, 
        tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
        tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
        FROM tproduct INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
        WHERE tproduct.bActive != 0 AND tproduct.nProductID = :id";
$statementSingleProduct = $connection->prepare($sqlSingleProduct);

$sqlRelatedProducts = "SELECT tproduct.nProductID, tproduct.cName as cProductName, tproduct.nCoffeeTypeID as nProductCoffeeTypeID, 
                        tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
                        tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                        FROM tproduct INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                        WHERE tproduct.bActive != 0 AND tproduct.nCoffeeTypeID = :coffeeID AND tproduct.nProductID != :id";
$statementRelatedProducts = $connection->prepare($sqlRelatedProducts);

$data =[
    ':id' => $iProductID
    ];

if ($statementSingleProduct->execute($data)) {
        $product = $statementSingleProduct->fetch(PDO::FETCH_ASSOC);

        $nCoffeeTypeID = $product['nCoffeeTypeID'];

        $imgUrl = $product['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));

$sTitle = '| Product: '.$imgUrl; // Add the product dynamically
$sCurrentPage = 'shop';

require_once(__DIR__ . '/components/header.php');

    if($_SESSION){
    $_SESSION['productID'] = $iProductID;
    }

?>

<main class="single-product">
<button class="back-button absolute">&lt;</button>
    <section class="section-one mb-large ph-large mt-small grid grid-two-thirds-reversed">      
        <?php
                        echo '
                        <div id="product-'.$iProductID.'" class="product-info-container grid grid-two-thirds">
                        <h1 class="productName text-left mh-small ph-small">'.$product['cProductName'].'</h1>
                            <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                            <div class="description mh-small mv-medium grid grid-two">
                                <div>
                                    <h4 class="productPrice mv-small">'.$product['nPrice'].' DKK</h4>
                                    <p>A soft, velvety body highlights a soft citric acidity and pleasant sweetness, with notes of raspberry, orange and sugar cane.</p>';

                        if($_SESSION){
                            $jLoggedUser = $_SESSION['user'];
                            $nUserID = $jLoggedUser['nUserID'];

                            $dataUserFavorites =[
                                ':id' => $nUserID,
                                ':productid' => $iProductID
                            ];

                            $sqlUserFavorites = "SELECT * FROM tfavorite WHERE nUserID = :id AND nProductID = :productid AND bActive = 1";
                            $statementUserFavorites = $connection->prepare($sqlUserFavorites);

                            if ($statementUserFavorites->execute($dataUserFavorites)) {
                                $favorite = $statementUserFavorites->fetch(PDO::FETCH_ASSOC);
                                // echo $favorite;
                                
                                if($favorite != false){
                                echo "
                                            <a class='likeBtn grid grid-almost-two align-items-center mv-small'>
                                                <p class='uppercase grid'>It's a favorite</p>
                                                <div class='likeBtnIcon active bg-contain'></div>
                                            </a>";
                                }
                                else{
                                    echo '  
                                                <a class="likeBtn grid grid-two-thirds-reversed align-items-center mv-small">
                                                    <p class="uppercase grid">Add to favorites</p>
                                                    <div class="likeBtnIcon inactive bg-contain"></div>
                                                </a>';
                                }
                            }
                        }
                        
                        echo'
                                </div>
                                <div class="mv-small">
                                    <h4 class="bold">Roast level</h4>
                                    <p class="light mb-small">Medium Roast</p>
                                    <h4 class="bold">Type</h4>
                                    <p class="productCoffeeType light mb-small">'.$product['cName'].'</p>
                                    <h4 class="bold">Recommmended for</h4>
                                    <p class="light">Espresso</p>
                                    <p class="light">French Press</p>
                                </div>
                            </div>
                        </div>
                        '
                        ?>
                        <div class="product-purchase-container bg-grey p-medium">
                            <div class="options-container grid mb-small">
                                <div class="options mv-small ">
                                    <h4 class="text-left bold pb-small">Quantity</h4>
                                   
                                    <label for="option1" class=" grid ">
                                        <input type="number" name="option1" value="1" class="">
                                        <p class="align-self-center pl-small">bag</p>
                                    </label>
                                </div>


                                <div class="options mv-small">
                                <h4 class="text-left bold pb-small">Grind</h4>
                                    <label>
                                        <input type="radio" name="grindType" value="whole" class="mb-small" checked>
                                        <div class="checkmark">Whole</div>
                                    </label>
                                    <label>
                                        <input type="radio" name="grindType" value="grind" class="mb-small">
                                        <div class="checkmark">Grind</div>
                                    </label>


                                </div>
                            </div>
                            <div class="payment">
                                <h3 class="align-self-bottom mt-medium text-right">Total amount</h3>
                                <h4 class="totalPrice align-self-top"><?= $product['nPrice']; ?> DKK</h4>
                                <button class="button margin-auto mv-small mt-medium" id="addToCartBtn">Add to cart</button>
                            </div>
                        </div>
    </section>

    <section class="section-three ph-large mb-medium">
      <h2 class="mb-small">You also might like</h2>
      <div class="related-products relative">
        <div class="container-banner absolute pv-large bg-light-brown"></div>
        <div class="products-container grid grid-four">

            <?php
}
    $data =[
        ':coffeeID' => $nCoffeeTypeID,
        ':id' => $iProductID
        ];

if ($statementRelatedProducts->execute($data)) {
        $products = $statementRelatedProducts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {

        $imgUrl = $product['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
        echo 
               ' <a href="singleProduct?id='.$product['nProductID'].'">
                    <div class="product relative" id="product-'.$product['nProductID'].'">
                        <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                        <div class="description m-small">
                            <h3 class="productName mt-small text-left">'.$product['cProductName'].'</h3>
                            <p class="productName mt-small text-left">'.$product['cName'].'</p>
                            <h4 class="productPrice mt-small absolute">'.$product['nPrice'].' DKK</h4>
                        </div>
                    </div>
                </a>';

    }
}
$connection = null;
?>
    </div>
      </div>
    </div>
    </div>
  </section>
  <script src="js/favorite.js"></script>
</main>

<?php
$connection = null;

$sScriptPath = 'sessionStorageCart.js';
require_once(__DIR__ . '/components/footer.php');
