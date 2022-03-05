<?php
session_start();

if(!$_SESSION){
    exit;
}

if($_SESSION){

$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];
$nProductID = $_SESSION['productID'];

require_once(__DIR__.'/../connection.php');

$data =[
    ':id' => $nUserID,
    ':productid' => $nProductID
];

$sqlGetActiveFavorite = "SELECT * FROM tfavorite WHERE nUserID = :id AND bActive = 1 AND nProductID = :productid";
$sqlGetInactiveFavorite = "SELECT * FROM tfavorite WHERE nUserID = :id AND bActive = 0 AND nProductID = :productid";

// ACTIVE
$statementActiveFavorite = $connection->prepare($sqlGetActiveFavorite);
$statementActiveFavorite->execute($data);
$resultActive = $statementActiveFavorite->fetchAll(PDO::FETCH_ASSOC);

// INACTIVE
$statementInactiveFavorite = $connection->prepare($sqlGetInactiveFavorite);
$statementInactiveFavorite->execute($data);
$resultInactive = $statementInactiveFavorite->fetchAll(PDO::FETCH_ASSOC);
    
    if(!empty($resultActive)){
        echo 'this favorite is already active';
        exit;
    }
    elseif(!empty($resultInactive)){

        $data =[
            ':id' => $nUserID,
            ':productid' => $nProductID
        ];

        $sqlUpdateInactiveFavorite =    "UPDATE tfavorite SET tfavorite.bActive = 1 
                                        WHERE nFavoriteID IN 
                                            (SELECT nFavoriteID FROM tfavorite 
                                            WHERE bActive = 0 AND nUserID = :id AND nProductID = :productid)";

        $statementUpdateInactiveFavorite = $connection->prepare($sqlUpdateInactiveFavorite);

            if($statementUpdateInactiveFavorite->execute($data)){
                echo 'updating inactive product';
                echo json_encode($data);
                $connection = null;
                exit;
            }
            else{
                echo 0;
                $connection = null;
                exit;
            }
    }
    else{

        $dataCreateNewFavorite =[
            ':id' => $nUserID,
            ':idUser' => $nUserID,
            ':productid' => $nProductID,
            ':productidExisting' => $nProductID,
            ':active' => 1
        ];

        $sqlCreateNewFavorite = "INSERT INTO tfavorite (nUserID, nProductID, bActive) 
                                SELECT :id, :productid, :active
                                WHERE NOT EXISTS
                                (SELECT nProductID, nUserID FROM tfavorite WHERE nUserID = :idUser AND nProductID = :productidExisting AND bActive = 1)";

        $statementCreateNewFavorite = $connection->prepare($sqlCreateNewFavorite);

        if($statementCreateNewFavorite->execute($dataCreateNewFavorite)){
            echo json_encode($dataCreateNewFavorite);
            $connection = null;
            exit;
        }
        else{
            echo 0;
            $connection = null;
            exit;
        }
    
    }

    echo 0;
    $connection = null;
    exit;
}

