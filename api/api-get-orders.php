<?php
session_start();

if (!$_SESSION) {
    header('Location: log-in');
    exit;
}

if ($_SESSION) {

require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/../components/functions.php');
    
$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];

if (isset($jLoggedUser['dDeleteUser'])) {
    header('Location: log-in');
    exit;
}

$sqlOrders = "SELECT tpurchase.nPurchaseID, tpurchase.nProductID, tpurchase.dPurchase, tpurchase.nNetAmount, tpurchase.nTax, 
                tproduct.cName AS cProductName, tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
                tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                FROM tpurchase
                INNER JOIN tproduct ON tpurchase.nProductID = tproduct.nProductID
                INNER JOIN tcreditcard ON tpurchase.nCreditCardID = tcreditcard.nCreditCardID
                INNER JOIN tuser ON tcreditcard.nUserID = tuser.nUserID
                INNER JOIN tcoffeetype on tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
                WHERE tuser.nUserID = :id 
                ORDER BY tpurchase.nPurchaseID DESC
                LIMIT 5,100";

  $statementOrders = $connection->prepare($sqlOrders);

  if ($statementOrders->execute([':id' => $nUserID])) {

    $result = $statementOrders->fetchALL(PDO::FETCH_ASSOC);
  
    $resultArray = json_encode($result);
  
    echo $resultArray;
    $connection = null;
    exit;
  }
  
  echo 0;
  $connection = null;

}