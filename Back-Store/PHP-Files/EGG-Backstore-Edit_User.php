<?php
session_start();
$users = simplexml_load_file("../../XML-files/users.xml") or die("Error. File not found.");

if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }

if (isset($_GET['ID'])){
    foreach ($users -> user as $user){
        if ($user['ID'] == $_GET['ID']){
            $ID = $_GET['ID'];
            $username = $user -> username;
            $email = $user -> email;
            $address = $user -> address;
            $isAdmin = $user -> isAdmin;
            $dateOfBirth = $user -> dateOfBirth;
        }
    }
} else {
    $username = "";
    $email = "";
    $address = "";
    $isAdmin = false;
    $dateOfBirth = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" sizes="16x16" />
    <link rel="stylesheet" href="../CSS/EGG-Backstore-Banner.css">
    <link rel="stylesheet" href="../CSS/EGG-Backstore-EditUser.css">
    <title>Edit User</title>
</head>

<body>
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
            <input class="form-control searchbar" type="text" placeholder="Search for User by ID">
            <button class="btn btn-primary" type="button">Search</button>
        </form>
    </div>
</nav>
<!-- END OF BANNER -->
<div style=" height: 15px;"></div>

<div class="container-sm pt-5 my-5">
    <form class="card p-3 bg-light" method="post" action= "UserXMLHandler.php" >
        <h2 class="card-title">Edit User</h2>
        <div>
              <?php if(isset($_GET['ID'])){
                    echo "<input type=\"hidden\" name=\"ID\" value=\"$_GET[ID]\">";
                } ?>
          </div>
          
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php echo $username?>" required>
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3 mt-3">
          <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $email?>" required>
          <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="address" placeholder="Enter Address" value="<?php echo $address?>">
            <label for="address">Address</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="date" class="form-control" max="<?php echo date("Y-m-d")?>" name="birthdate" placeholder="Enter Date of Birth" value="<?php echo $dateOfBirth?>" required>
            <label for="birthdate">Date of Birth</label>
        </div>
        <div class="form-floating mb-3 mt-3">
          <input type="password" class="form-control" name="password" placeholder="Enter new Password" minlength="5">
          <label for="password">Password</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <div class="form-check" style="float:right;">
                <?php if ($isAdmin == "true"){
                    echo "<input type=\"checkbox\" name=\"isAdmin\" checked>";
            } else {
                echo "<input type=\"checkbox\" name=\"isAdmin\" >";
            }?>
            <label for="isAdmin"> Check if Admin account</label>
       </div>
        </div>
        <span>
            <button type="submit" class="btn btn-primary submit">Submit</button>
            <button type="reset" class="btn btn-primary submit" value="Clear">Clear</button>
        </span>
      </form>
  </div>
</body>
</html>