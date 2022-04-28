<?php 
session_start();
$orders = simplexml_load_file("../../XML-files/Orders.xml") or die("Error. File not found.");
$orderProducts = array();

if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
  header('location: ../../index.php?log=in');
  exit();
  }


foreach($orders -> order as $order){
    if (isset($_GET['id'])){

        if ($order['id'] == $_GET['id']){
            $custID = $order -> customerID;
            $username = $order  -> username;
            $address = $order -> address;
            $total = $order -> total;

            foreach($order -> products as $products){
                foreach($products -> product as $product){
                    array_push($orderProducts, $product);
                }
            }
        }
    }
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
    <link rel="stylesheet" href="../CSS/EGG-Backstore-EditOrder.css">
    <link rel="stylesheet" href="../CSS/styleorder.css">
    <title>Edit Order</title>
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
            <input class="form-control searchbar" type="text" placeholder="Search an Order by ID">
            <button class="btn btn-primary" type="button">Search</button>
        </form>
    </div>
</nav>
<!-- END OF BANNER -->
<div style=" height: 15px;"></div>
<div class="container-sm pt-5 my-5">
    <form class="card p-3 bg-light maincard" method="post" action="OrderXMLHandler.php" >
        <h2 class="card-title">Edit Order</h2>
        <div class="input-group mb-3">
            <div class="form-floating flex-grow-1 mb-3 mt-3">
                <input type="number" class="form-control" id="orderID" name="orderID" placeholder="Enter Order ID" readonly value="<?php echo (isset($_GET['id'])? $_GET['id'] : "")?>">
                <label for="orderID">Order ID</label>
            </div>
            <div class="form-floating flex-grow-1 mb-3 mt-3">
                <input type="text" class="form-control" name="custID" placeholder="Enter Customer uID" value="<?php echo (isset($custID)? $custID : "")?>" required>
                <label for="custID">Customer uID</label>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table cartTable">
              <tbody id="tableBody">
                <?php
                $order_total = 0;
                foreach($orderProducts as $orderProduct){
                    $id = (string) $orderProduct['id'];
                    $imagename = $orderProduct -> imagename;
                    $title = $orderProduct -> title;
                    $price = $orderProduct -> price;
                    $quantity = $orderProduct -> quantity;;
                    $total = $price * $quantity;
                    $order_total += $total;
                ?>
                <tr class="productrow" id="<?php echo $id?>" >
                  <td class="col-2">
                    <div class="text-center">
                      <img src="<?php echo $imagename?>" class="figure-img cart-pic"></img>
                      <div class="figure-caption fw-bold"><?php echo $title?></div>
                    </div>
                  </td>
                  <td class="col qty-row">
                    <div class = "text-center">
                      <input type="button" value="-" class="minus"></input>
                      <input class="input-text qty text" type="number" step="1" min="1" max="10" name="Quantity" value="<?php echo $quantity?>" size="4" pattern="" inputmode=""></input>
                      <input type="button" value="+" class="plus"></input>
                      <div>
                        <span class="prodPrice">$<?php echo $price?></span><span>/unit</span>
                      </div>
                    </div>
                  </td>
                  <td class="col-2">
                    <div class="text-center">
                      <div><strong>Total</strong></div>
                      <div class="totalProdPrice">$<?php echo number_format((float)($total), 2, '.', '')?></div>
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
            <button type="button" class="btn btn-primary addProdBtn mt-3" data-bs-toggle="modal" data-bs-target="#addProdModal">Add Product</button>
        <div class="input-group ">
            <span class="input-group-text mb-3 mt-3">$</span>
            <span class="form-floating flex-grow-1 mb-3 mt-3">
                <input type="number" step="0.01" class="form-control total" id="total" name="total" placeholder="Total:" readonly value="<?php echo $order_total?>">
                <label for="total">Total</label>
            </span>
        </div>
          
        <span>
            <button type="submit" class="btn btn-primary  submit">Submit</button>
            <button type="reset" class="btn btn-primary submit" value="Clear">Clear</button>
        </span>
      </form>
  </div>
<!-- Modal -->
<div class="modal fade" id="addProdModal" tabindex="-1" >
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-center d-inline-block">
        <button type="button" class="btn-close modal-x-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="modalLabel">Add a product</h5>
      </div>
      <div class="modal-body text-center">
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="modalProdID" placeholder="Enter Product ID to add">
            <label for="email">Product ID</label>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id= "modalAddBtn" class="btn btn-primary modalAddBtn" data-bs-dismiss="modal">Add</button>
      </div>
  </div>
</div>
</div>
<script src="../JS/editOrder.js"></script>
</body>
</html>