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
    <title>Backstore Users</title>
</head>

<?php
$USER_PATH = "../../XML-files/users.xml";
$xml = simplexml_load_file($USER_PATH);

function get_permissions($IS_ADMIN) {
    return $IS_ADMIN == "true" ? "Admin":"Customer";
} 

// Get aisle number and product number of product to delete
// Then, unset xml element

if (isset($_GET["del"])) {
    $user_id = $_GET["del"];
    $nb_users = count($xml->user);
    for ($i = 0; $i<$nb_users; $i++) {
        if ( $xml->user[$i] !== NULL && $xml->user[$i]->attributes()->ID == $user_id) {
            unset($xml->user[$i]);
        }
    }

    // Write back xml info to file
    $xml->asXml($USER_PATH);

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
            User List
            <a href="EGG-Backstore-Edit_User.php" class="btn btn-primary">Add User</a>
        </h2>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- FIRST USER -->
        <?php foreach ($xml as $User) : ?>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $User->username ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo "ID: ".$User->attributes()->ID?></h6>
                <p class="card-text"><b>Email: </b></br><?php echo $User->email ?></p>
                <p class="card-text"><b>Adress: </b></br><?php echo $User->address ?></p>
                <p class="card-text"><b>Birthdate: </b><?php echo $User->dateOfBirth ?></p>
                <p class="card-text"><b>Permissions: </b><?php echo get_permissions($User->isAdmin) ?></p>
            </div>
            <span style="align-self:center; margin-bottom:10px;">
                <a href="EGG-Backstore-Edit_User.php?ID=<?php echo $User->attributes()->ID ?>" class="card-link">Edit User</a>
                <a href="EGG-Backstore-Users.php?del=<?php echo $User->attributes()->ID ?>" class="card-link">Delete User</a>
            </span>
        </div>

        <?php endforeach; ?>

    </div>
</div>