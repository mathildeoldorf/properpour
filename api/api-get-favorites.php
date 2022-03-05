<?php

session_start();

if(!$_SESSION){
    exit;
}

if($_SESSION){

$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];

require_once(__DIR__.'/../connection.php');

$dataUserFavorites =[
    ':id' => $nUserID
];

$sqlUserFavorites = "SELECT tfavorite.nProductID, 
tproduct.cName, tproduct.nPrice, 
tcoffeetype.cName AS cCoffeeName
FROM tfavorite
INNER JOIN tproduct ON tfavorite.nProductID = tproduct.nProductID
INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
WHERE tfavorite.nUserID = :id AND tfavorite.bActive = 1 AND tproduct.bActive = 1";
$statementUserFavorites = $connection->prepare($sqlUserFavorites);

    if ($statementUserFavorites->execute($dataUserFavorites)) {
    $favorites = $statementUserFavorites->fetchAll(PDO::FETCH_ASSOC);

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