<?php
 session_start();
 $products_data = simplexml_load_file("../../XML-files/Products.xml") or die("Error. File not found.");

//finding the right product to display
 foreach($products_data -> aisle as $loop_aisle) {
   foreach($loop_aisle -> product as $loop_product) {
     if ($loop_product['id'] == $_GET['id']) {
       $product = $loop_product;
     }
   }
 }

//choosing script file based on sale or not
if (!isset($product->saleprice) or trim($product->saleprice) == "" or (float) $product->saleprice == 0) {
  $scriptName = "../JS-files/Product.js";
}
else {
  $scriptName = "../JS-files/ProductDiscount.js";
}

//add to cart
if (isset($_POST['addToCart'])) {
  header('location: ShoppingCart.php');
}



//main product info
 $title = $product -> title;
 $weight = $product -> weight;
 $quantity = $product -> quantity;
 $saleprice = $product -> saleprice;
 $price = $product -> price;
 $description = $product -> description;
 $product_ID = $product -> product_ID;
 $imagename = $product -> imagename;
 $allergy = $product -> allergy;
 $similar_1 = $product -> similarID1;
 $similar_2 = $product -> similarID2;
 $similar_3 = $product -> similarID3;

$similarArray =array();
 foreach($products_data -> aisle as $loop_aisle) {
   foreach($loop_aisle -> product as $loop_product) {
     if ((int) $loop_product['id'] == (int) $similar_1) {
        array_push($similarArray, $loop_product);
     }
   }
 }

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
  <link rel="stylesheet" type="text/css" href="../CSS-files/ProductCSS.css">
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <title>EGG Grocery Shopping</title>
  <style media="screen">
  .background-img{
    background-image:linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.5)), url("<?php echo $imagename?>");
  }
  </style>
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
      <li class="nav-item">
        <a class="nav-link" href="../../index.php?log=in">Home</a>
      </li>
      <li class="nav-item dropdown"><div class="dropdown">
            <button class="dropbtn">Aisles<p class="arrow">&#9660;</p>
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


<!--Product-->
<div class="product-box" id="<?php echo $product['id']?>">
  <div class="img-bg background-img">
    <div class="reset-box">
      <div class="new-box">
        <div class="product-image-box">
          <img class="product-image" src="<?php echo $imagename?>" alt="ProductImage">
        </div>


        <div class="product-info" id="1">
          <h2 class="product-title" title="<?php echo $title?>"><?php echo $title?></h2>
          <p class="product-quantity"><?php echo $quantity?> (approx. <?php echo $weight?>)</p>
          <div class="product-price">
            <p class="price-display">approx
              <?php if (!isset($product->saleprice) or trim($product->saleprice) == "" or (float) $product->saleprice == 0) {?>
                <span class="price">$<span class="price-value"><?php echo $price?></span></span>/<span class="unit">unit</span>
              <?php } else {?>
                <span class="price">$<span class="price-value"><?php echo $saleprice?></span></span>/<span class="unit">unit</span><span class="old-price">$<span class="newoldprice"><?php echo $price?></span>/<span class="oldunit">unit</span></span>
              <?php }?>
            </p>
          </div>

          <!--Quantity button-->
          <div class="quantity buttons_added">
            <form class="formCart" method="post">
              <input type="button" value="-" class="minus"><input type="number" step="1" min="1" max="10" name="quantity" value="1" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus">
          </div>

          <!--Add to Cart button-->
          <div class="button_section">
              <input type="submit" value="Add to Cart" name="addToCart" class="btn btn-primary cart"></input>
            </form>
          </div>

          <!--Description-->
          <div class="description-btn">
            <button class="btn btn-primary btn-descr" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              More Description
            </button>
            <div class="collapse" id="collapseExample">
              <div class="card card-body description">
                <?php echo $description?>
                <br>Product-ID: <?php echo $product_ID?>
                <br><?php echo $allergy?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!--Frequently bought together-->
<div class="similar-products-box">
  <div class="freq-title-box">
    <div class="freq-title">
  	  Other <strong>Eggcelent</strong> buyers also buy...
  	</div>
  </div>
  <!--Frequently bought together-->
  <div class="row freq-bought">
<?php 
foreach($similarArray as $similar){
 $similar_title = $similar -> title;
 $similar_image = $similar -> imagename;
 $similar_price = $similar -> price;
 $similar_saleprice = $similar -> saleprice;
 $similar_ID = $similar['id'];

?>
  	<!--First card-->
    <div class="card coll-lg-4 p-3 shadow mb-5 rounded mx-auto" style="width: 18rem;">
    		<img src="<?php echo $similar_image?>" class="card-img-top" alt="product image">
    			<div class="card-body freq_pr">
      			<h5 class="card-title"><?php echo $similar_title?></h5>
              <p class="card-text">
                <?php if (isset($similar -> saleprice)) {?>
                <span class="new-price">$<?php echo $similar_saleprice?>/unit<span class="old-price">$<?php echo $similar_price?>/unit
                <?php } else {?>
                <span class="new-price">$<?php echo $similar_price?>/unit
                <?php }?>
              </p>
      			<a href="ProductPageDefault.php?id=<?php echo $similar_ID?>" class="btn btn-primary">See product</a>
    			</div>
  	</div>
  </div>
</div>
<?php }?>


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

<!--Homemade scripts-->
<script type="text/javascript" src="<?php echo $scriptName?>"></script>


</body>
</html>
