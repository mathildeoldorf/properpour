<?php
if($_POST){
    require_once(__DIR__.'/../components/functions.php');

    $product = $_POST['activateName'];
    $stock = $_POST['activateStock'];

    if(empty($_POST['activateStock'])){
        sendErrorMessage('stock missing', __LINE__);
    }
    if(empty($_POST['activateName'])){
        sendErrorMessage('name missing', __LINE__);
    }
    if(!ctype_digit($_POST['activateStock'])){
        sendErrorMessage('not a number', __LINE__);
    }

    require_once(__DIR__.'/../connection.php');

    $sqlFindProduct = "SELECT nProductID FROM tproduct WHERE cName=:product";
    $statementFindProduct = $connection->prepare($sqlFindProduct);

    $data =[
        ':product' => $product
    ];

    if($statementFindProduct->execute($data)){
        $productID = $statementFindProduct->fetch(PDO::FETCH_COLUMN);
        echo $productID;

        $sql = "UPDATE tproduct SET bActive=1, nStock=:stock WHERE nProductID=:product";
        $statement = $connection->prepare($sql);
    
    $data =[
        'product' => $productID,
        'stock' => $stock
    ];

    if($statement->execute($data)){
        echo '{"status":1, "message":"product successfully activated and stock is updated"}';
        $connection = null;
        exit;
    }
    }
    else{
        echo 0;
        $connection = null;
        exit;
    } 
}
