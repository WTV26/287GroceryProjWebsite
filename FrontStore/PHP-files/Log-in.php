<?php
  $xml = simplexml_load_file("../../XML-files/users.xml");
  $isExisting = true;
  session_start();

  if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    foreach($xml->user as $loopuser){
      if($loopuser->username == $username and password_verify($password, $loopuser->password)){
        $_SESSION["UN"] = $username;
        $_SESSION["PASS"] = (string) $loopuser->password;
        $isAdmin = (string) $loopuser->isAdmin;
        $_SESSION["AD"] = $isAdmin;
        $isExisting = true;

        if ($isAdmin == "true") {
          header('location: ../../Back-Store/index.php');
        }
        else {
          header('location: ../../index.php?log=in');
        }
        break;
      }
      else {
        $isExisting = false;
      }
    }
  }
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="Grocery, Food, Shopping">
  <meta name="description" content="Browse the contents of Elite'sGreat Grocery (EGG)">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <link rel="stylesheet" href="../CSS-files/loginCSS.css">

  <title>EGG Grocery Shopping</title>
</head>


<!--Bootstrap-implemented NavBar (which was tweaked and changed quite
a bit)-->
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
      <li class="nav-item dropdown">
        <div class="dropdown">
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
        <a class="nav-link" href="Log-in.php">
          <div id="login-button">
            <div class="active"><?php if (isset($_SESSION['UN'])) {echo $_SESSION['UN'];}else{?>Log in<?php }?></div>
          </div>
        </a>
      </li>
    </ul>
  </div>
</nav>
<!--Searchbar-->
<div id="searchbar_section">
  <input class="searchbar" type="text" name="search" placeholder="Search for an item...">
</div>

<div class=body>
  <!--Alert for login-->
  <div class="alert-box">
    <div class="alert login-alert shadow p-3 mb-3 rounded" role="alert">
      <?php if (isset($_SESSION['UN'])) {?>
        <span>Want to sign out? <a href="../../index.php?log=out">Log out</a>!</span>
      <?php } else {?>
        <span>Don't have an account? <a href="Sign-up.php">Sign up</a>!</span>
      <?php }?>
    </div>
  </div>


  <form method="post" action="" class="sign-up-box" >
    <div class="SignUpWindow p-3 text-white; shadow p-3 mb-5 rounded">
      <div>
        <h4>Login</h4>
      </div>


      <div class="information-block shadow p-3 mb-5 bg-body rounded">

        <!--entering email-->
        <div class="enter-info">
          <label for="exampleFormControlInput1" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Username">
        </div>

        <!-- Enter password-->
        <div class="enter-info ">
          <label for="exampleFormControlInput1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="exampleFormControlInput1" placeholder="Password">
        </div>
        <?php if (!$isExisting) {?> <p style="color:red;">Wrong username or password.</p><?php }?>

        <!--Remember me check box-->
        <div class="form-check enter-info">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault"> Remember me</label>
        </div>

        <!--Login button-->
        <div class="d-flex gap-2 box">
          <button class="btn signup-btn" name="login" type="submit">Login</button>
          <!--Forgot password-->
          <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="forgot-pass">Forgot password?</a> <!--With javascript, will implement alert/toast to ask email-->
        </div>
      </div>
    </div>

  </form>
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
            <li class="mb-2"><a href="#CardsTitle" class="text-white">Promotions</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
          <h6 class="text-uppercase font-weight-bold mb-4">Company</h6>
          <ul class="list-unstyled mb-0">

            <li class="mb-2"><a href="Log-in.php" class="text-white">Login</a>
            <li class="mb-2"><a href="Sign-up.php" class="text-white">Register</a>
            <li class="mb-2"><a href="Shopping_Cart.php" class="text-white">Cart</a>
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

</html>
