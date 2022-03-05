<?php

session_start();

if(!$_SESSION){
    exit;
}

if($_SESSION){

    $jLoggedUser = $_SESSION['user'];
    $nUserID = $jLoggedUser['nUserID'];

    if($_SESSION['productID'] != false){
        $nProductID = $_SESSION['productID'];
    };

    if($_SESSION['productID'] == false){
        $nProductID = $_POST['productID'];
    }

    require_once(__DIR__.'/../connection.php');

        $sql = "UPDATE tfavorite SET bActive = :inactive WHERE nUserID = :id AND nProductID = :productid AND bActive = 1";

        $statement = $connection->prepare($sql);
    
        $data =[
            ':id' => $nUserID,
            ':productid' => $nProductID,
            ':inactive' => 0
        ];

        if($statement->execute($data)){
            echo 1;
            $connection = null;
            exit;
        }
        else{
            echo 0;
            $connection = null;
            exit;
        }
}