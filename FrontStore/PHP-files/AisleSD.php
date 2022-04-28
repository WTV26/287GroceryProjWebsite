<?php
$products_data = simplexml_load_file("../../XML-files/Products.xml");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="Grocery, Food, Shopping">
  <meta name="description" content="Browse the contents of Elite's Great Grocery (EGG)">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../CSS-files/Aisles-StylesheetNew.css">
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <title>EGG Grocery Shopping</title>
</head>

<body>
<!--Bootstrap-implemented NavBar (which was tweaked and changed quite a bit)-->
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="../../index.php?log=in"><img class="logo" src="../../images/EGGlogo.png" alt="EGG logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../../index.php?log=in">Home</a>
      </li>
      <li class="nav-item dropdown"><div class="dropdown">
            <button class="dropbtn"><span class="active">Aisles</span><p class="arrow">&#9660;</p>
            </button>
            <div class="dropdown-content">
              <a href="AisleVF.php">Fruits & Vegetables</a>
              <a href="AisleDM.php">Dairy & Meat</a>
              <a href="AisleSD.php">Snacks & Drinks</a>
            </div>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ShoppingCart.php">Cart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Log-in.php"><div id="login-button"><?php if (isset($_SESSION['UN'])) {echo $_SESSION['UN'];}else{echo "Log in";}?></div></a>
      </li>
    </ul>
  </div>
</nav>

<!--Searchbar-->
  <div id="searchbar_section">
    <input class = "searchbar" type="text" name="search" placeholder="Search for an item...">
  </div>


<!--Product Aisle-->
<div class="Products_Aisle bg-SD">
  <h1 class="AisleTitle"><strong class="glowTextPink">Snacks</strong> and <strong class="glowTextPink">Drinks</strong></h1>
  <div class="aisle-searchbar">
    <input class="aisle-bar SD-searchbar" type="text" name="SDsearch" placeholder="Search for snacks or drinks...">
  </div>

  <div class="row">

    <?php foreach ($products_data->aisle[2]->product as $product): ?>

    <!--Card -->
    <div class="col-dm-4 card bg-lilac">
      <a class="img-link" href="ProductPageDefault.php?id=<?php echo $product['id']?>">
        <img class="card-img-top img-fluid" src="<?php echo $product -> imagename?>" alt="<?php echo $product -> title?>">
      </a>
      <div class="card-body d-flex flex-column">
        <a class="title-link" href="ProductPageDefault.php?id=<?php echo $product['id']?>"><h5 class="card-title"><?php echo $product -> title?></h5></a>
        <div class="price">
        <p class="card-text">
        <?php if (!isset($product->saleprice) or trim($product->saleprice) == "" or (float) $product->saleprice == 0) {?>
            <span class="new-price">$<?php echo $product -> price?>/unit</p></span>
          <?php } else {?>
            <span class="old-price">$<?php echo $product -> price?>/unit</span>
            <span class="new-price">$<?php echo $product -> saleprice?>/unit</p></span>
          <?php }?>
        </div>
        <div class="button_section">
        <a href="ProductPageDefault.php?id=<?php echo $product['id']?>" class="btn btn-primary">See Product</a>
        <button id="<?php echo $product['id']?>" class="btn btn-secondary addToCart">Add to Cart</button>
        </div>
      </div>
    </div>

  <?php endforeach;?>

</div>

  <!--Pagination-->
      <nav aria-label="pagination-box">
        <ul class="pagination">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item disabled" aria-current="page">
            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
          </li>
          <li class="page-item disabled"><a class="page-link" href="#">3</a></li>
          <li class="page-item disabled">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>
</div>



<!-- Footer -->
<footer class="bg-custom-footer">
  <div class="container py-5">
    <div class="row py-4">
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 first-col"><img src="../../images/EGGlogo.png" alt="EGG logo" width="180" class="mb-3">
        <p class="font-italic text-white">At EGG, we strive to make online grocery shopping a memorable experience.<strong><br> Be great</strong>.</p>
        <ul class="list-inline mt-4">
          <li class="list-inline-item"><a href="https://twitter.com/hashtag/eggs" target="_blank" title="twitter"><i class="fa fa-twitter-square"></i></a></li>
          <li class="list-inline-item"><a href="https://www.facebook.com/eggs/" target="_blank" title="facebook"><i class="fa fa-facebook-square"></i></a></li>
          <li class="list-inline-item"><a href="https://www.instagram.com/world_record_egg/" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
          <li class="list-inline-item"><a href="https://www.pinterest.com/bgskcollege/eggs/" target="_blank" title="pinterest"><i class="fa fa-pinterest-square"></i></a></li>
          <li class="list-inline-item"><a href="https://vimeo.com/330010344" target="_blank" title="vimeo"><i class="fa fa-vimeo-square"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase font-weight-bold mb-4">Shop</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="AisleVF.php" class="text-white">Vegetables and Fruits</a></li>
          <li class="mb-2"><a href="AisleDM.php" class="text-white">Dairy and Meat</a></li>
          <li class="mb-2"><a href="AisleSD.php" class="text-white">Snacks and Drinks</a></li>
          <li class="mb-2"><a href="../../index.php?log=in" class="text-white">Promotions</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase font-weight-bold mb-4">Company</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="Log-in.php" class="text-white">Login</a></li>
          <li class="mb-2"><a href="Sign-up.php" class="text-white">Register</a></li>
          <li class="mb-2"><a href="ShoppingCart.php" class="text-white">Cart</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6 mb-lg-0">
        <h6 class="text-uppercase font-weight-bold mb-4">Newsletter</h6>
        <p class="text-white mb-4 font-italic">Subscribe to our EGG magazine and receive all the best deals possible!</p>
        <div class="p-1 rounded border">
          <div class="input-group">
            <input type="email" placeholder="Enter your email address" aria-describedby="button-addon1" class="form-control border-0 shadow-0">
            <div class="input-group-append">
              <button id="button-addon1" type="submit" class="btn btn-link"><i class="fa fa-paper-plane"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Copyrights -->
  <div class="bg-custom-copyright py-4">
    <div class="container text-center">
      <p class="mb-0 py-2">© 2022 EGG All rights reserved.</p>
    </div>
  </div>
</footer>

<script type="text/javascript" src="../JS-files/AddToCartAisleNew.js"></script>

</body>

</html>
