<?php
Session_start();
$products = simplexml_load_file("../../XML-files/Products.xml") or die("Error. File not found.");

if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }
$actualProdID = "";

if (isset($_GET['id'])){
    $actualProdID = $_GET['id'];
    foreach($products -> aisle as $aisle){
        foreach($aisle -> product as $product){
            if ($product['id'] == $_GET['id']){
                $aisleName = $product['class'];
                $title = $product -> title;
                $product_ID = $product -> product_ID;
                $weight = $product -> weight;
                $price = $product -> price;
                $salePrice = $product -> saleprice;
                $quantity = $product -> quantity;
                $description = $product -> description;
                $similarID1 = $product -> similarID1;
                $similarID2 = $product -> similarID2;
                $similarID3 = $product -> similarID3;
            }
        }
    }
} else {
    $title = "";
    $product_ID = "";
    $weight = "";
    $price = "";
    $salePrice = "";
    $quantity = "";
    $description = "";
    $similarID1 = "";
    $similarID2 ="";
    $similarID3 = "";
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
    <link rel="stylesheet" href="../CSS/EGG-Backstore-EditProduct.css">
    <title>Edit Product</title>
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
            <input class="form-control searchbar" type="text" placeholder="Search for product by ID">
            <button class="btn btn-primary" type="button">Search</button>
        </form>
    </div>
</nav>
<div style=" height: 15px;"></div>

<!-- END OF BANNER -->
<div class="container-sm pt-5 my-5">
    <form class="card p-3 bg-light" method="post"  enctype="multipart/form-data" action="ProductXMLHandler.php">
        <h2 class="card-title">Edit Product</h2>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="prodID" placeholder="Enter Product ID" value="<?php echo $product_ID;?>" required>
            <label for="prodID">Product ID</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <select class="form-select" id="prodAisle" name="prodAisle">
                <?php switch($aisleName){
                    case "VeggiesFruits":
                        echo "<option value=\"VeggiesFruits\" selected>Veggies and Fruits</option>";
                        echo "<option value=\"DairyMeat\">Dairy and Meat</option>";
                        echo "<option value=\"SnacksDrinks\">Snacks and Drinks</option>";
                        break;
                    case "DairyMeat":
                        echo "<option value=\"VeggiesFruits\">Veggies and Fruits</option>";
                        echo "<option value=\"DairyMeat\" selected >Dairy and Meat</option>";
                        echo "<option value=\"SnacksDrinks\">Snacks and Drinks</option>";
                        break;

                    case "SnacksDrinks":
                        echo "<option value=\"VeggiesFruits\">Veggies and Fruits</option>";
                        echo "<option value=\"DairyMeat\">Dairy and Meat</option>";
                        echo "<option value=\"SnacksDrinks\" selected>Snacks and Drinks</option>";
                        break;
                    default:
                    echo "<option value=\"VeggiesFruits\" selected>Veggies and Fruits</option>";
                    echo "<option value=\"DairyMeat\">Dairy and Meat</option>";
                    echo "<option value=\"SnacksDrinks\">Snacks and Drinks</option>";
                    break;
                }
                echo "</select>"; ?>
            <label for="prodAisle">Aisle</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="prodName" placeholder="Enter Product Name" value="<?php echo $title;?>" required>
            <label for="prodName">Product Name</label>
        </div>
          <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="prodQuantity" placeholder="Enter Product Quantity" value="<?php echo $quantity;?>">
            <label for="prodQuantity">Product Quantity</label>
          </div>
          <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="weight" placeholder="Enter Product Weight" value="<?php echo $weight;?>">
            <label for="weight">Product Weight</label>
          </div>
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="similar1" placeholder="Similar Product 1" value="<?php echo $similarID1;?>">
            <label for="similar1">Similar Product 1</label>
          </div>
          <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="similar2" placeholder="Similar Product 2" value="<?php echo $similarID2;?>">
            <label for="similar2">Similar Product 2</label>
          </div>
          <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="similar3" placeholder="Similar Product 3" value="<?php echo $similarID3;?>">
            <label for="similar3">Similar Product 3</label>
          </div>
          <div class="input-group ">
            <span class="input-group-text mb-3 mt-3">$</span>
            <span class="input-group-text mb-3 mt-3">0.00</span>
            <span class="form-floating flex-grow-1 mb-3 mt-3">
                <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter Product Price" value="<?php echo $price;?>" required>
                <label for="price">Price</label>
            </span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text mb-3 mt-3">$</span>
            <span class="input-group-text mb-3 mt-3">0.00</span>
            <span class="form-floating flex-grow-1 mb-3 mt-3">
                <input type="number" step="0.01" class="form-control" name="salePrice" placeholder="Enter Product Sale Price" value="<?php echo $salePrice;?>">
                <label for="salePrice">Sale Price</label>
            </span>
        </div>
          <div class="input-group mb-3">
            <input type="file" class="form-control" name="prodImg" accept="image/png, image/jpeg"> 
            <label class="input-group-text" for="prodImg">Upload new image</label>
        </div>
        <div class="form-floating mb-3 mt-3">
            <textarea class="form-control" name="description" rows="3"><?php echo $description;?></textarea>
            <label for="description">Product Description</label>
        </div>
        <?php if(trim($actualProdID) != ""){ ?>
          <div>
          <input type="hidden" name="productID" value="<?php echo $actualProdID?>">
          </div>
        <?php } ?>
        <span>
            <button type="submit" class="btn btn-primary submit">Submit</button>
            <button type="reset" class="btn btn-primary submit" value="Clear">Reset</button>
        </span>
      </form>
  </div>
</body>
</html>