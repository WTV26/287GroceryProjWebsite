<?php
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    } else {
    header("Location: EGG-Backstore-Edit_Order.php");
    }

$orders=simplexml_load_file("../../XML-files/Orders.xml") or die("Error. File not found.");

if (trim($_POST['orderID']) != ''){
    $id = $_POST['orderID'];
    editOrder($id);
} else {
    addNew(idDecider());
}

function idDecider(){
    global $orders;
    $id = 0 ;
    $idsTaken = array();
    foreach($orders -> order as $order){
        array_push($idsTaken, $order['id']);
    }

    for ($i = 0; $i < count($idsTaken); $i++){
        if(in_array($id, $idsTaken)){
            $id++;
        }
    } 

    return $id;
}

function addNew($id){
    global $orders;
    $order = $orders -> addChild('order');
    $order -> addAttribute('id', $id);
    $order -> addChild('customerID', $_POST['custID']);
    $order -> addChild('total', $_POST['total']);
    $order -> addChild('products');
    $product = $order -> products -> addChild('product');
}

function editOrder($id){
    global $orders;
    foreach($orders -> order as $order){
        if($order['id'] == $id){
            $order -> customerID = $_POST['custID'];
            $order -> total = $_POST['total'];
            foreach($order -> products as $products){
                foreach($products -> product as $product){
                    if($product['id'] == $_POST['prodID']){
                        $product -> quantity = $_POST['qty'];
                        break;
                    }
                }
            }
        }
    }
}

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($orders->asXML());
    $dom->save("../../XML-files/Orders.xml");
?>