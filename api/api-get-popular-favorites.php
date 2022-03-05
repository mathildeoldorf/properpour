<?php

session_start();

if(!$_SESSION){
    exit;
}

if($_SESSION){

require_once(__DIR__.'/../connection.php');

// RELATED PRODUCTS BASED ON ALL USER FAVORITES
$sqlPopularFavorites = "SELECT DISTINCT tproduct.nProductID, tproduct.cName, 
tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName AS cCoffeeName
FROM tproduct
INNER JOIN tcoffeetype
  ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
WHERE tproduct.bActive = 1 AND tProduct.nProductID IN
    (SELECT tfavorite.nProductID FROM tfavorite
    INNER JOIN tproduct ON tfavorite.nProductID = tproduct.nProductID 
    WHERE tproduct.bActive = 1
    GROUP BY tproduct.cName 
    HAVING COUNT(*) > 1)
    LIMIT 4";

$statementPopularFavorites = $connection->prepare($sqlPopularFavorites);

if ($statementPopularFavorites->execute()) {
    $favorites = $statementPopularFavorites->fetchAll(PDO::FETCH_ASSOC);

    if($favorites != false){
        echo json_encode($favorites);
        $connection = null;
        exit;
    }
    else{
        echo 0;
        $connection = null;
        exit;
    }

    }

}