<?php
if($_POST){
    
    if(empty($_POST['newPrice'])){
        sendErrorMessage('Price missing', __LINE__);
    }
    if(empty($_POST['newStock'])){
        sendErrorMessage('stock missing', __LINE__);
    }
    if(empty($_POST['newName'])){
        sendErrorMessage('name missing', __LINE__);
    }
    if(empty($_POST['newCoffeetype'])){
        sendErrorMessage('coffetype missing', __LINE__);
    }
    if(!ctype_digit($_POST['newCoffeetype'])){
        sendErrorMessage('not a number', __LINE__);
    }
    if(!ctype_digit($_POST['newStock'])){
        sendErrorMessage('not a number', __LINE__);
    }
    if(!ctype_digit($_POST['newPrice'])){
        sendErrorMessage('not a number', __LINE__);
    }

    require_once(__DIR__.'/../connection.php');
    require_once(__DIR__.'/../components/functions.php');

    $sql = "INSERT INTO tproduct (cName, nPrice, nStock, nCoffeeTypeID) VALUES (:name, :price, :stock, :coffeetype)";
    $statement = $connection->prepare($sql);

    $data =['name' => $_POST['newName'],
        'price' => $_POST['newPrice'],
        'stock' => $_POST['newStock'],
        'coffeetype' => $_POST['newCoffeetype']
    ];

    if($statement->execute($data)){
        echo '{"status":1, "message":"Product successfully created"}';
        $connection = null;
        exit;
    }

    $connection = null;
    exit;
}