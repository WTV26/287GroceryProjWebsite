<?php
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }else {
        header("Location: EGG-Backstore-Edit_Order.php");
    }
    
$orders=simplexml_load_file("../../XML-files/Orders.xml") or die("Error. File not found.");

switch($_GET['act']){
    case 'delete':
        foreach($orders -> order as $order){
            if($order['id'] == $_GET['order']){
                foreach($order -> products as $products){
                    foreach($products -> product as $product){
                        if($product['id'] == $_GET['prodID']){
                            $dom = dom_import_simplexml($product);
                            $dom->parentNode->removeChild($dom);
                        }
                    }
                }
                $order -> total = $_GET['total'];
            }
        }
        break;

    case 'edit':
        foreach($orders -> order as $order){
            if($order['id'] == $_GET['order']){
                foreach($order -> products as $products){
                    foreach($products -> product as $product)
                        if($product['id'] == $_GET['prodID']){
                            $product -> quantity = $_GET['qty'];
                            break;
                        }
                }
                $order -> total = $_GET['total'];
            }
        }
        break;

}

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($orders->asXML());
    $dom->save("../../XML-files/Orders.xml");
?>