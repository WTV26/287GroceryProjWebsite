<?php
session_start();
$products_data = simplexml_load_file("../../XML-files/Products.xml") or die("Error. File not found.");

// if (!isset($_SESSION['UN'])) {
//   header("location: Log-in.php");
// }

if (!isset($_SESSION['products']) or !isset($_SESSION['quantities'])) {
  $_SESSION['products'] = array();
  $_SESSION['quantities'] = array();
}

$subtotal = 0;
$GST =0;
$QST =0;
$count =0;


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="Grocery, Food, Shopping">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../CSS-files/style-shoppingcart-new.css">
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <title>EGG Grocery Shopping Cart</title>
</head>

<div class="wrapper">
<!--Bootstrap-implemented NavBar (which was tweaked and changed quite a bit)-->
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="../../index.php?log=in"><img class="logo" src="../../images/EGGlogo.png" alt="EGG logo"></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
      <li class="nav-item active">
        <a class="nav-link" href="ShoppingCart.php"><div class="active">Cart</div></a>
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



<!--SHOPPING CART-->
<body>
  <div class="container-sm my-5">
    <div class="row">
      <div class="col">
        <form class="card p-3 bg-light maincard" >
          <h3 class="card-title">Shopping Cart</h3>
          <div class="card">
            <div class="table-responsive">
            <table class="table cartTable">
              <tbody>
                <?php foreach($_SESSION['products'] as $product) {
      					$product = new SimpleXMLElement($product);
      					$id =(string) $product['id'];
                $new_price;
                  if (!isset($product->saleprice) or trim($product->saleprice) == "" or (float) $product->saleprice == 0) {
                    $new_price = (double) $product->price;
                  } else {
                    $new_price = (double) $product->saleprice;
                  }

                  $quantity = (int) $_SESSION['quantities'][$id];

                  $subtotal += $quantity * $new_price;
                  $GST += $quantity * $new_price * 0.05;
                  $QST += $quantity * $new_price * 0.09975;

                  ?>
                <tr class="productrow" <?php echo "id=\"$id\""?>>
                  <td class="col-2">
                    <div class="text-center">
                      <img src="<?php echo "$product->imagename"?>" class="figure-img cart-pic"></img>
                      <div class="figure-caption fw-bold"><?php echo $product->title?></div>
                    </div>
                  </td>
                  <td class="col qty-row">
                    <div class = "text-center">
                      <input type="button" value="-" class="minus"></input>
                      <input class="input-text qty text" type="number" step="1" min="1" max="10" title="Quantity" value="<?php echo $quantity?>" size="4" pattern="" inputmode=""></input>
                      <input type="button" value="+" class="plus"></input>
                      <div>
                        <span class="prodPrice">$<?php echo "$new_price"?></span><span>/unit</span>
                      </div>
                    </div>
                  </td>
                  <td class="col-2">
                    <div class="text-center">
                      <div><strong>Total</strong></div>
                      <div class="totalProdPrice">$<?php echo number_format((float)($new_price * $quantity), 2, '.', '')?></div>
                      </div>
                  </td>
                  <td class="col-1 removebtnCol">
                      <button type="button" class="btn removebtn"></button>
                  </td>
                </tr>
              <?php }?>
              </tbody>
            </table>
            </div>
          </div>
          <div class="card mt-3 orderSummary">
            <div class="card-header">Order Summary: </div>
            <div class="card-body">
              <p id="subtotal">Subtotal: $<?php echo number_format((float)$subtotal, 2, '.', '')?></p>
              <p id="gst">GST: $<?php echo number_format((float)$GST, 2, '.', '')?></p>
              <p id="qst">QST: $<?php echo number_format((float)$QST, 2, '.', '')?></p>
              <p id="total" class="fw-bold">Total: $<?php echo number_format((float)($subtotal + $GST + $QST), 2, '.', '')?></p>
            </div>
          </div>
          <span class="d-grid justify-content-md-end mt-3">
            <button class="btn btn-primary paymentButton" type="button" data-bs-toggle="modal" data-bs-target="#paymentModal">Continue</button>
          </span>
        </form>
      </div>
    </div>
  </div>
  <div class="d-flex flex-grow-1"></div>
<!-- Footer -->
<footer class="bg-custom-footer">
  <div class="container py-5 footerContainer">
    <div class="row py-4">
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 first-col"><img src="../../images/EGGlogo.png" alt="EGG logo" width="180" class="mb-3">
        <p class="fst-italic text-white">At EGG, we strive to make online grocery shopping a memorable experience.<strong><br> Be great</strong>.</p>
        <ul class="list-inline mt-4">
          <li class="list-inline-item"><a href="https://twitter.com/hashtag/eggs" target="_blank" title="twitter"><i class="fa fa-twitter-square"></i></a></li>
          <li class="list-inline-item"><a href="https://www.facebook.com/eggs/" target="_blank" title="facebook"><i class="fa fa-facebook-square"></i></a></li>
          <li class="list-inline-item"><a href="https://www.instagram.com/world_record_egg/" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
          <li class="list-inline-item"><a href="https://www.pinterest.com/bgskcollege/eggs/" target="_blank" title="pinterest"><i class="fa fa-pinterest-square"></i></a></li>
          <li class="list-inline-item"><a href="https://vimeo.com/330010344" target="_blank" title="vimeo"><i class="fa fa-vimeo-square"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase fw-bold mb-4">Shop</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="AisleVF.php" class="text-white ">Vegetables and Fruits</a></li>
          <li class="mb-2"><a href="AisleDM.php" class="text-white ">Dairy and Meat</a></li>
          <li class="mb-2"><a href="AisleSD.php" class="text-white ">Snacks and Drinks</a></li>
          <li class="mb-2"><a href="../../../index.php?log=in" class="text-white ">Promotions</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase fw-bold mb-4">Company</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="Log-in.php" class="text-white ">Login</a></li>
          <li class="mb-2"><a href="Sign-up.php" class="text-white ">Register</a></li>
          <li class="mb-2"><a href="ShoppingCart.php" class="text-white ">Cart</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6 mb-lg-0">
        <h6 class="text-uppercase fw-bold mb-4">Newsletter</h6>
        <p class="text-white mb-4 fst-italic">Subscribe to our EGG magazine and receive all the best deals possible!</p>
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

<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" >
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-center d-inline-block">
        <button type="button" class="btn-close modal-x-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="modalLabel">Payment Details</h5>
      </div>
      <div class="modal-body text-center">
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder="Enter email">
            <label for="email">Email address</label>
          </div>
          <div class="form-floating cardNum mb-3">
            <input type="number" class="form-control" id="cardNum" placeholder="Card Number">
            <label for="cardNum">Card Number</label>
          </div>
          <div class="input-group mb-3">
            <span class="form-floating cardDate">
                <input type="text" class="form-control" id="cardDate" placeholder="MM/YY" minlength="5" maxlength="5">
                <label for="cardDate">MM/YY</label>
            </span>
            <span class="form-floating CVV">
              <input type="text" class="form-control" id="CVV" placeholder="CVV" maxlength="4">
              <label for="CVV">CVV</label>
           </span>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="cardName" placeholder="Enter cardholder name">
            <label for="cardName">Cardholder Name</label>
          </div>
          <h5> Billing Details </h5>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="billingAddress" placeholder="Enter billing address">
            <label for="billingAddress">Billing Adress</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="postalCode" placeholder="Enter postal code" minlength="6" maxlength="6">
            <label for="postalCode">Postal Code</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Pay</button>
      </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../JS-files/ShoppingCartNew.js"></script>
</body>
</html>
