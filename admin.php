<?php 
$sTitle = ' | Admin'; 
$sCurrentPage = 'admin'; 
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
?>

<main class="admin">

<h1 class="text-center pt-small">Manage Products</h1>
<div class="adminProducts">
<?php
    $sql = "SELECT * FROM tproduct WHERE bActive=1";
    $statement = $connection->prepare($sql);

    if($statement->execute()){
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        $connection = null;
    
    foreach($products as $row){
            
            echo '
            <div class="adminProduct grid grid-one" id="product-'.$row['nProductID'].' ">
            <h3 class="bold uppercase adminProductName">'.$row['cName'].' </h3>
            <h5 class="text-left uppercase">Current price</h5>
            <p class="adminPropertyPrice">'.$row['nPrice'].' DKK.</p>
            <form method="post" class="frmUpdatePrice"> 
    <label for=""><p>Update Price</p><input type="text" name="updatePrice"></label> 
    <button type="submit" class="button btnUpdatePrice">UPDATE</button>
</form>
            <h5 class="text-left uppercase">Current stock</h5>
            <p class="propertyStock">'.$row['nStock'].' units</p>
            <form method="post" class="frmUpdateStock"> 
    <label for=""><p>Update Stock</p><input type="text" name="updateStock"></label>
    <button type="submit" class="button btnUpdateStock">UPDATE</button>
</form>
<button class="btnDeleteProduct button-delete button">Delete </button>
            </div>
            ';
        
    }   
}

$connection = null;

?>
</div>
<section class="grid grid-two">
<div>
<h2>Add Coffee products</h2>
<form method="POST" id="frmAddProduct">
    <label for="">Name<input type="text" name="newName"></label>
    <label for="">Price<input type="text" name="newPrice"></label>
    <label for="">Coffee Type
        <select name="newCoffeetype" id="">
            <option value="1">Columbia</option>
            <option value="2">Ethiopia</option>
            <option value="3">Sumatra</option>
            <option value="4">Brazil</option>
            <option value="5">Nicaragua</option>
            <option value="6">Blend</option>
        </select>
    </label>
    <label for="">Stock<input type="text" name="newStock"></label>
        <button class="button btnAddProduct">Add Product</button>
        </form>
</div>

<div>
<h2>Activate Coffee products</h2>
<form method="POST" id="frmActivateProduct">
    <label for="">Name<input type="text" name="activateName"></label>
    <label for="">Stock<input type="text" name="activateStock"></label>
        <button class="button btnActivateProduct">Activate Product</button>
        </form>
</div>
</section>

</main>
<?php
$sScriptPath = 'admin.js';
require_once(__DIR__.'/components/footer.php');