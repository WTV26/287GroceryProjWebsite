<?php
session_start();
$products_data = simplexml_load_file("./XML-files/Products.xml") or die("Error. File not found.");

if (!isset($_GET['log'])) {
  //$_GET['log'] = 'in';
  header('location: index.php?log=in');
}

if ($_GET['log'] == 'out') {
  session_destroy();
  unset($_SESSION['UN']);
  unset($_SESSION['PASS']);
  unset($_SESSION['AD']);
}

$promotionArray = array();
foreach($products_data -> aisle as $aisle){
  foreach($aisle -> product as $product){
    if(trim($product->saleprice) != "" or (float) $product->saleprice != 0){
      array_push($promotionArray, $product);
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
  <meta name="description" content="HOME: Browse the contents of Elite's Great Grocery (EGG)">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="./FrontStore/CSS-files/GroceryHomeStylesheetNew.css">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <title>EGG Grocery Shopping</title>
</head>

<body>
<!--Bootstrap-implemented NavBar (which was tweaked and changed quite a bit)-->
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="index.php?log=in"><img class="logo" src="./images/EGGlogo.png" alt="EGG logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php?log=in"><div class="active">Home</div></a>
      </li>
      <li class="nav-item dropdown"><div class="dropdown">
            <button class="dropbtn">Aisles<p class="arrow">&#9660;</p>
            </button>
            <div class="dropdown-content">
              <a href="./FrontStore/PHP-files/AisleVF.php">Fruits & Vegetables</a>
              <a href="./FrontStore/PHP-files/AisleDM.php">Dairy & Meat</a>
              <a href="./FrontStore/PHP-files/AisleSD.php">Snacks & Drinks</a>
            </div>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./FrontStore/PHP-files/ShoppingCart.php">Cart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./FrontStore/PHP-files/Log-in.php"><div id="login-button"><?php if (isset($_SESSION['UN'])) {echo $_SESSION['UN'];}else{echo "Log in";}?></div></a>
      </li>
    </ul>
  </div>
</nav>

<!--Searchbar-->
<div id="searchbar_div">
  <div id="searchbar_section">
    <input class="searchbar" type="search" name="search" placeholder="Search for an item...">
  </div>
  <div class="searchbar_drop" style="visibility:hidden;">
    <ul id="searchbar_dropdown">
      <li><a href="./FrontStore/PHP-files/ProductPageDefault.php?id=0000">apple</a></li>
      <li><a id="middle_li" href="./FrontStore/PHP-files/ProductPageDefault.php?id=0002">potatoes</a></li>
      <li><a href="./FrontStore/PHP-files/ProductPageDefault.php?id=2000">sangria</a></li>
    </ul>
  </div>
</div>

<!--Welcome Page -->
  <div class="jumbotron jumbotron-fluid bg-img">
    <div class="container">
      <img class="home_logo" src="./images/EGGlogo.png" alt="EGG logo">
        <h1 class="display-4"><span class="glowTextYellow">E</span>lite's <span class="glowTextYellow">G</span>reat <span class="glowTextYellow">G</span>rocery</h1>
      <p class="lead">Online grocery shopping reimagined.<br>Where grocery shopping meets <i>beauty</i> and <i>greatness</i>.</p>
    </div>
  </div>

<!--Boostrap-implemented Aisles Carousel-->
<div class="AisleCarousel">
      <div id="Carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#Carousel" data-slide-to="0" class="active"></li>
          <li data-target="#Carousel" data-slide-to="1"></li>
          <li data-target="#Carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <a href="./FrontStore/PHP-files/AisleVF.php">
              <img src="./images/veggie_fruits.jpg" class="w-100" alt="veggies/fruits">
            </a>
            <div class="carousel-caption">
              <h3 class="carousel-titles"><a class="carousel-btn" href="./FrontStore/PHP-files/AisleVF.php"><span class="glowTextGreen">V</span>egetables and <span class="glowTextGreen">F</span>ruits</a></h3>
              <p>Wide variety of fresh, locally grown vegetables and fruits.</p>
            </div>
          </div>
          <div class="carousel-item">
            <a href="./FrontStore/PHP-files/AisleDM.php">
              <img src="./images/dairy_meat.jpg" class="w-100" alt="dairy/meat">
            </a>
            <div class="carousel-caption">
              <h3 class = "carousel-titles"><a class="carousel-btn" href="./FrontStore/PHP-files/AisleDM.php"><span class="glowTextBlue">D</span>airy and <span class="glowTextBlue">M</span>eat</a></h3>
              <p>Great selection of Quebec's most delicious local meats and dairy products.</p>
            </div>
          </div>
          <div class="carousel-item">
            <a href="./FrontStore/PHP-files/AisleSD.php">
              <img src="./images/snacks_drinks.jpg" class="w-100" alt="snacks/drinks">
            </a>
            <div class="carousel-caption">
              <h3 class="carousel-titles"><a class="carousel-btn" href="./FrontStore/PHP-files/AisleSD.php"><span class="glowTextPink">S</span>nacks and <span class="glowTextPink">D</span>rinks</a></h3>
              <p>All your favourite snacks and refreshing drinks.</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#Carousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#Carousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


</div>

<!--Bootstrap-implemented Promotion Cards-->
<div class="Promotions">
  <h2 id="CardsTitle">See our greatest <strong>Promotions</strong></h2>
  <div class="row">
    <!--Card 1-->
    <?php
    $counter = 0;
    foreach ($promotionArray as $promotion){
      $price = $promotion -> price;
      $saleprice = $promotion -> saleprice;
      $title = $promotion -> title;
      $imageTEMP = (string) ($promotion -> imagename);
      $image = substr($imageTEMP, 6);
      if ($counter++ == 3) {
        break;
      }
    ?>

    <div class="col-dm-4 card bg-lilac">
      <a class="img-link" href="./FrontStore/PHP-files/ProductPageDefault.php?id=<?php echo $promotion['id']?>">
        <img class="card-img-top img-fluid" src="<?php echo $image?>">
      </a>
      <div class="card-body d-flex flex-column">
        <a class="title-link" href="./FrontStore/PHP-files/ProductPageDefault.php?id=<?php echo $promotion['id']?>"><h5 class="card-title"><?php echo $title?></h5></a>
        <div class="price">
        <p class="card-text"><span class="old-price">$<?php echo $price?>/unit</span><span class="new-price">$<?php echo $saleprice?>/unit</p>
        </div>
        <div class="button_section">
        <a href="./FrontStore/PHP-files/ProductPageDefault.php?id=<?php echo $promotion['id']?>" class="btn btn-primary">See Product</a>
        <button id="<?php echo $promotion['id']?>" class="btn btn-secondary addToCart">Add to Cart</button>
        </div>
      </div>
    </div>
<?php } ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-custom-footer">
  <div class="container py-5">
    <div class="row py-4">
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 first-col"><img src="./images/EGGlogo.png" alt="EGG logo" width="180" class="mb-3">
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
          <li class="mb-2"><a href="./FrontStore/PHP-files/AisleVF.php" class="text-white">Vegetables and Fruits</a></li>
          <li class="mb-2"><a href="./FrontStore/PHP-files/AisleDM.php" class="text-white">Dairy and Meat</a></li>
          <li class="mb-2"><a href="./FrontStore/PHP-files/AisleSD.php" class="text-white">Snacks and Drinks</a></li>
          <li class="mb-2"><a href="./FrontStore/PHP-files/index.php?log=in" class="text-white">Promotions</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase font-weight-bold mb-4">Company</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="./FrontStore/PHP-files/Log-in.php" class="text-white">Login</a></li>
          <li class="mb-2"><a href="./FrontStore/PHP-files/Sign-up.php" class="text-white">Register</a></li>
          <li class="mb-2"><a href="./FrontStore/PHP-files/ShoppingCart.php" class="text-white">Cart</a></li>
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
<!-- End -->

<script type="text/javascript" src="./FrontStore/JS-files/Search.js"></script>
<script type="text/javascript" src="./FrontStore/JS-files/AddToCartIndex.js"></script>

</body>

</html>
