<?php 
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }
?>

<!DOCTYPE html>

<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="icon" href="../images/favicon.ico" type="image/x-icon" sizes="16x16" />
<link rel="stylesheet" href="../CSS/EGG-Backstore-Banner.css">
<link rel="stylesheet" href="../CSS/EGG-Backstore-Lists.css">
<title>Backstore Products</title>
</head>

<?php
$PRODUCT_PATH = "../../XML-files/Products.xml";
$xml = simplexml_load_file($PRODUCT_PATH);

function aisle_from_class($class) {
    $split_arr = preg_split('/(?=[A-Z])/',$class);
    return $split_arr[1]." and ".$split_arr[2];

    /* Function takes class name like 

            "VeggiesFruits"

    and returns string

            "Veggies and Fruits"

    but both seperated words must start with a capital letter
    */
}

// Get aisle number and product number of product to delete
// Then, unset xml element

if (isset($_GET["del"])) {
    $product_id = $_GET["del"];    
    $nb_aisles = count($xml->aisle);

    for ($i = 0; $i<$nb_aisles; $i++) {
        $nb_prods = count($xml->aisle[$i]);
        if ($nb_prods !== 0) {
            for ($j = 0; $j<$nb_prods; $j++) {
                if ($xml->aisle[$i]->product[$j] !== NULL) {
                    if ($product_id == $xml->aisle[$i]->product[$j]->product_ID) {
                        if(file_exists($xml->aisle[$i]->product[$j]->imagename) and filesize($xml->aisle[$i]->product[$j]->imagename) > 1000 and !is_dir($xml->aisle[$i]->product[$j]->imagename)) {
                            unlink($xml->aisle[$i]->product[$j]->imagename);
                        }
                        unset($xml->aisle[$i]->product[$j]);
                        break 2;
                    }
                }
            }
        }
    }
    // Write back xml info to file
    $xml->asXml($PRODUCT_PATH);

}
?>

<!-- START OF BANNER -->
<nav class="navbar navbar-expand-md fixed-top">
    <div class="container-fluid">
        <span class="navbar-headerandtoggler">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <span class="navbar-header">
              <a class="navbar-brand" href="../index.php">EGG Backstore</a>
            </span>
        </span>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" role="button" href="../../index.php">Front Store</a>
                </li> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Products</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="EGG-Backstore-Products.php">Product list</a></li>
                    <li><a class="dropdown-item" href="EGG-Backstore-Edit_Product.php">Edit products</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Users</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="EGG-Backstore-Users.php">User list</a></li>
                    <li><a class="dropdown-item" href="EGG-Backstore-Edit_User.php">Edit user</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Orders</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="EGG-Backstore-Orders.php">Order list</a></li>
                    <li><a class="dropdown-item" href="EGG-Backstore-Edit_Order.php">Edit order</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <form class="d-flex flex-grow-1 search search">
            <input class="form-control searchbar" type="text" placeholder="Search an Order by ID">
            <button class="btn btn-primary" type="button">Search</button>
        </form>
    </div>
</nav>
<!-- END OF BANNER -->



<div class="list_container">
    <div class="list_header">
        <h2>
            Product List
            <a href="EGG-Backstore-Edit_Product.php" class="btn btn-primary">Add Product</a>
        </h2>
    </div>
</div>

<div class="container">
    <div class="row">

    <?php foreach ($xml as $Aisle) :?>
            <?php if (count($Aisle) == 0) continue; ?> 
            <?php $aisle_name = aisle_from_class($Aisle->product[0]->attributes()->class); ?>

            <?php foreach ($Aisle as $Product) :?>
                <?php $prod_num = (int)$Product->attributes()->id; ?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?php echo "$Product->imagename" ?>" alt="Card image cap">
                    <div class="card-body" style="text-align: center;">
                        <h5 class="card-title"><?php echo $Product->title ?></h5>
                        <h5 class="card-title"><?php echo "(\${$Product->price})" ?></h5>
                        <p class="card-text"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo "ID: ".$Product->product_ID ?></li>
                        <li class="list-group-item"><?php echo $aisle_name ?></li>
                        <li class="list-group-item"><?php echo "Weight: ".$Product->weight ?></li>
                        <li class="list-group-item"><?php echo "Quantity: ".$Product->quantity ?></li>
                    </ul>
                    <div class="card-body" style="display: flex; justify-content: space-around;">
                            <a href="EGG-Backstore-Edit_Product.php?id=<?php echo $Product->attributes()->id ?>" class="card-link del">Edit Item</a>
                            <a href="EGG-Backstore-Products.php?del=<?php echo $Product->product_ID ?>" class="card-link del">Delete Item</a>  
                    </div>
                </div>

        <?php endforeach; ?>
    <?php endforeach; ?>

    </div>
</div>