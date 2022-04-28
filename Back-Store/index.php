<?php
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../index.php?log=in');
    exit();
    }

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="CSS/EGG-Backstore-Banner.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" sizes="16x16" />
    <link rel="stylesheet" href="CSS/EGG-Backstore-Lists.css">
    <title>Backstore Home</title>
</head>

<!-- START OF BANNER -->
<nav class="navbar navbar-expand-md fixed-top ">
    <div class="container-fluid">
        <span class="navbar-headerandtoggler">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-header">
              <a class="navbar-brand " href="index.php">EGG Backstore</a>
            </span>
        </span>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" role="button" href="../index.php">Front Store</a>
                </li> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Products</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Products.php">Product list</a></li>
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Edit_Product.php">Edit products</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Users</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Users.php">User list</a></li>
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Edit_User.php">Edit user</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Orders</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Orders.php">Order list</a></li>
                    <li><a class="dropdown-item" href="PHP-Files/EGG-Backstore-Edit_Order.php">Edit order</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <form class="d-flex flex-grow-1 search search">
            <input class="form-control searchbar" type="text" placeholder="Search">
            <button class="btn btn-primary" type="button">Search</button>
        </form>
    </div>
</nav>
<!-- END OF BANNER -->

<div class="list_container"></div>

<div class="container" margin>
    <div class="row">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="images/products_menublock_img.png" alt="Card image cap">
            <div class="card-body" style="justify-content: center;">
                <h5 class="card-title">Product List</h5>
                <p class="card-text">View the list of our fresh products and manage the backstore by editing, adding or
                    deleting products.</p>
                </div>
                <a id="editor" href="PHP-Files/EGG-Backstore-Products.php" class="btn btn-primary">Go to editing</a>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="images/userp_menublock_img.png" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">User List</h5>
                <p class="card-text">View the list of our wonderful costumers and manage the backstore by editing,
                    adding or
                    deleting profiles.</p>
                </div>
                <a id="editor" href="PHP-Files/EGG-Backstore-Users.php" class="btn btn-primary">Go to editing</a>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="images/cart_menublock_img.png" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Order List</h5>
                <p class="card-text">View the list of the current orders and manage the backstore by editing, adding or
                    deleting orders.</p>
                </div>
                <a id="editor" href="PHP-Files/EGG-Backstore-Orders.php" class="btn btn-primary">Go to editing</a>
        </div>
    </div>
</div>