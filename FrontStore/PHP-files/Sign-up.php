<?php
  $isPass = false;
  $isEmail = false;
  $isYear = false;
  $isExisting = false;
  $count = 0;

  if(isset($_POST["signup"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordcheck = $_POST["passwordcheck"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $emailcheck = $_POST["emailcheck"];

    if($password != $passwordcheck){
      $isPass = true;
    }
    elseif($email != $emailcheck and $email != null and $email != ""){
      $isEmail = true;
    }
    elseif($username != null and $password != null and $email != null and $address != null){
    $xml = new DOMDocument("1.0", "UTF-8");
    $xml->formatOutput = true;
    $xml->preserveWhiteSpace = false;
    $xml->load('../../XML-files/users.xml');
    $xmlcheck = simplexml_load_file("../../XML-files/users.xml");

    foreach($xmlcheck->user as $check){
      if($check->email == $email){
        $isExisting = true;
      }
    }

    function idDecider(){
      global $xmlcheck;
      $id = 0 ;
      $idsTaken = array();
  
      foreach($xmlcheck -> user as $user){
          array_push($idsTaken, $user['ID']);
      }
  
      foreach($idsTaken as $idTaken){
          if(in_array($id, $idsTaken)){
              $id++;
          }
      } 
  
      return $id;
  }

    $id = idDecider();

      if(!$isExisting){
        $users = $xml->getElementsByTagName("users")->item(0);
          $user = $xml->createElement("user");
          $user->setAttribute("ID", $id);
            $UN = $xml->createElement("username", $username);
            $PW = $xml->createElement("password", password_hash($password, PASSWORD_DEFAULT));
            $EM = $xml->createElement("email", $email);
            $AD = $xml->createElement("address", $address);
            $DOB = $xml->createElement("dateOfBirth", $dateOfBirth);
            $ADMIN = $xml->createElement("isAdmin", "false");

            $user->appendChild($UN);
            $user->appendChild($PW);
            $user->appendChild($EM);
            $user->appendChild($AD);
            $user->appendChild($DOB);
            $user->appendChild($ADMIN);

          $users->appendChild($user);
          $xml->save("../../XML-files/users.xml");

          session_start();
          $_SESSION["UN"] = $username;
          $_SESSION["ADMIN"] = $ADMIN;
          header('location: ../../index.php');
        }
    }
  }
?>

<!DOCTYPE>
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
  <link rel="stylesheet" href="../CSS-files/signUpCSS.css">
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" sizes="16x16" />
  <title>EGG Grocery Shopping</title>
</head>


<body>
  <div>
    <!--Bootstrap-implemented NavBar (which was tweaked and changed quitea bit)-->
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
                <div class="active">Log in</div>
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



    <form method="post" action="">
      <!--Alert for login-->
      <div class="alert-box">
        <div class="alert login-alert shadow p-3 mb-3 rounded" role="alert">
          Already have an account? <a href="Log-in.php">Log in</a>!
        </div>
      </div>

      <!--division for the Sign up box-->
      <div class="sign-up-box">
        <div class="SignUpWindow p-3 shadow mb-5 rounded">
          <div>
            <h4>Sign Up</h4>
          </div>



          <div class="information-block shadow p-3 mb-5 bg-body rounded">

            <!--Entering first and last name-->


              <div class="enter-info">
                <label for="exampleFormControlInput1" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Username" required>
              </div>

            <div class="enter-info">
              <label for="birthdate">Date of Birth</label>
              <input type="date" class="form-control" required max="<?php echo date("Y-m-d")?>" name="dateOfBirth" placeholder="Enter Date of Birth" value="<?php echo $dateOfBirth?>">
            </div>

            <!--entering email-->
            <div class="enter-info">
              <label for="exampleFormControlInput1" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com" required>
            </div>

            <!-- reentering email-->
            <div class="enter-info">
              <label for="exampleFormControlInput1" class="form-label">Re-enter Email address</label>
              <input type="email" class="form-control" name="emailcheck"id="exampleFormControlInput1" placeholder="name@example.com" required>
            </div>

            <?php if($isEmail){ ?> <p style="color:red;">Please input matching email</p> <?php }?>
            <?php if($isExisting){ ?> <p style="color:red;">Account with current email already created</p> <?php }?>
            <!-- entering adress -->

              <div class="enter-info">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" id="exampleFormControlInput1" placeholder="address">
              </div>


            <!-- Enter password-->
            <div class="enter-info ">
              <label for="exampleFormControlInput1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="exampleFormControlInput1" placeholder="Password"  minlength="8" required>
            </div>

            <!--Re enter password-->
            <div class="enter-info ">
              <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="passwordcheck" id="exampleFormControlInput1" placeholder="Re-enter password" minlength="8" required>
            </div>

            <?php if($isPass){ ?> <p style="color:red;">Please input matching password</p> <?php }?>

            <!--Remember me check box-->
            <div class="form-check enter-info">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault"> Remember me</label>
            </div>

            <!--Sign up button-->
            <div class="d-grid gap-2">
              <button class="btn btn-primary signup-btn" name="signup" type="submit">Sign up</button>
              <a class="reset-btn" href="Sign-up.php">Reset page</a>
            </div>


          </div>
        </div>
        <!--closes signup box-->
      </div>
      <!--closes outer div-->
    </form>

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
