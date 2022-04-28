<?php 
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" sizes="16x16" />
    <link rel="stylesheet" href="../CSS/EGG-Backstore-Banner.css">
    <link rel="stylesheet" href="../CSS/EGG-Backstore-Lists.css">
    <title>Backstore Orders</title>
</head>

<?php
$ORDER_PATH ="../../XML-files/Orders.xml";
$xml = simplexml_load_file($ORDER_PATH);
$USER_PATH = "../../XML-files/users.xml";
$users = simplexml_load_file($USER_PATH);
// Get aisle number and product number of product to delete
// Then, unset xml element

function get_name($uid) {
    global $users;
    foreach ($users as $User) {
        if (strcmp($User->attributes()->ID, $uid) == 0) {
            return $User->username;
        }
    }
}

if (isset($_GET["del"])) {
    $order_id = $_GET["del"];
    $nb_orders = count($xml->order);
    for ($i = 0; $i<$nb_orders; $i++) {
        if ($xml->order[$i] !== NULL && $xml->order[$i]->attributes()->id == $order_id) {
            unset($xml->order[$i]);
        }
    }

    // Write back xml info to file
    $xml->asXml($ORDER_PATH);
    
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
            Order List
            <a href="EGG-Backstore-Edit_Order.php" class="btn btn-primary">Add Order</a>
        </h2>
    </div>
</div>

<div class="container" style="margin-top: 10px">
    <div class="row">
        
        <?php foreach ($xml as $Order): ?>

            <div class="card orderCard">
                <div class="card-header">
                    Order #<?php echo $Order->attributes()->id ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">User <?php echo get_name($Order->customerID) ?></h5>
                    <ul class="list-group">
                        <?php foreach ($Order->products->product as $Product) : ?>
                            <li class="list-group-item">
                                <?php
                                    echo "<b>".$Product->title." [ID#{$Product->attributes()->id}]"."</b>";
                                    echo "<br>Quantity: ".$Product->quantity."</br>";
                                    echo "Sub total: $".(((float)$Product->price)*((float)$Product->quantity));
                                ?>
                            </li>
                        <?php endforeach; ?>    
                    </ul>
                    <p class="card-text"></br>Total: $<?php echo $Order->total ?></p>
                    <div class="card-body">
                        <a href="EGG-Backstore-Edit_Order.php?id=<?php echo $Order->attributes()->id ?>" class="card-link">Edit Order</a>
                        <a href="EGG-Backstore-Orders.php?del=<?php echo $Order->attributes()->id ?>" class="card-link">Delete Order</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>