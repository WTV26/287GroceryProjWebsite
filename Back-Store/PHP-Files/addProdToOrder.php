<?php
session_start();

if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }
$orders = simplexml_load_file("../../XML-files/Orders.xml") or die("Error. File not found.");
$products = simplexml_load_file("../../XML-files/Products.xml") or die("Error. File not found.");
$product;
$quantity;
$title;
$price;
$id = $_GET['prodID'];
$orderID = "";

if (trim($_GET['prodID']) == '' or !isset($_GET['prodID'])){
    exit();
}

if (!isset($_GET['orderID']) or trim($_GET['orderID']) == ''){
    $orderID = idDecider();
}
echo "$orderID\n";

function idDecider(){
    global $orders;
    $id = 0 ;
    $idsTaken = array();
    foreach($orders -> order as $order){
        array_push($idsTaken, $order['id']);
    }

    foreach($idsTaken as $idTaken){
        if(in_array($id, $idsTaken)){
            $id++;
        }
    } 

    return $id;
}

$found = false;
foreach($products -> aisle as $aisle){
    foreach($aisle -> product as $product){
        if($product['id'] == $_GET['prodID']){
            $imagename = $product -> imagename;
            $title = $product -> title;
            $price = $product -> price;
            $id = $product['id'];
            $found = true;
            break;
        }
    }
}
if(!$found){
    echo "false";
    exit();
}
if (!isset($_GET['orderID']) or trim($_GET['orderID']) == ''){
    $order = $orders -> addChild('order');
    $order -> addAttribute('id',$orderID);
    $products = $order -> addChild('products');
    $product = $products -> addChild('product');
    $product -> addAttribute('id', $_GET['prodID']);
    $product -> addChild('quantity', 1);
    $product -> addChild('title', $title);
    $product -> addChild('price', $price);
    $product -> addChild('imagename', $imagename);
    $quantity = $product -> quantity;
}else{
    foreach($orders -> order as $order){
        if ($order['id'] == $_GET['orderID']){
            foreach($order -> products as $products){
                foreach($products -> product as $product){
                    if($product['id'] == $_GET['prodID']){
                        exit();
                    }
                }
                $product = $products -> addChild('product');
                $product -> addAttribute('id', $_GET['prodID']);
                $product -> addChild('quantity', 1);
                $product -> addChild('title', $title);
                $product -> addChild('price', $price);
                $product -> addChild('imagename', $imagename);
                $quantity = $product -> quantity;
            }
        }
    }
}
 $returnHtml = <<<LIMITER
 <tr class="productrow" id="$id">
 <td class="col-2">
   <div class="text-center">
     <img src="$imagename" class="figure-img cart-pic"></img>
     <div class="figure-caption fw-bold">$title</div>
   </div>
 </td>
 <td class="col qty-row">
   <div class = "text-center">
     <input type="button" value="-" class="minus"></input>
     <input class="input-text qty text" type="number" step="1" min="1" max="10" name="Quantity" value="$quantity" size="4" pattern="" inputmode=""></input>
     <input type="button" value="+" class="plus"></input>
     <div>
       <span class="prodPrice">$$price</span><span>/unit</span>
     </div>
   </div>
 </td>
 <td class="col-2">
   <div class="text-center">
     <div><strong>Total</strong></div>
     <div class="totalProdPrice">$$price</div>
     </div>
 </td>
 <td class="col-1 removebtnCol">
     <button type="button" class="btn removebtn"></button>
 </td>
</tr>
LIMITER;

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($orders->asXML());
$dom->save("../../XML-files/Orders.xml");

echo $returnHtml;

?>