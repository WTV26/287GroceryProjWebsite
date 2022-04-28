<?php
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }else{
        header ('location: EGG-Backstore-Edit_Product.php');
    }

$products = simplexml_load_file("../../XML-files/Products.xml");
$id;
if (!isset($_POST['productID']) or trim($_POST['productID']) == ""){
    $id = idDecider($_POST['prodAisle']);
    addNew($id);
} else {
    $id = $_POST['productID'];
    editProd($id);
}

function idDecider($aisleName){
    global $id;
    global $products;
    $idsTaken = array();

    switch($aisleName){
        case "VeggiesFruits":
            $id = 0000;
            break;
        case "DairyMeat":
            $id = 1000;
            break;
        case "SnacksDrinks":
            $id = 2000;
            break;
    }

    foreach($products -> aisle as $aisle){
        if (strcmp($aisle['class'], $aisleName) == 0){
            
            foreach($aisle -> product as $product){
                array_push($idsTaken, $product['id']);
            }
        }

    }
    foreach($idsTaken as $idTaken){
        echo $idTaken;
        if(in_array($id, $idsTaken)){
            $id++;
        }
    } 
    return $id;
}

function addNew($id){
    global $products;
    $target_file = "../../images/" . basename($_FILES["prodImg"]["name"]);

    foreach($products -> aisle as $aisle){
        if ($aisle['class'] == $_POST['prodAisle'] ){
            $product = $aisle -> addChild('product');
            $product -> addAttribute('id', $id);
            $product -> addAttribute('class', $_POST['prodAisle']);
            $product -> addChild('title', $_POST['prodName']);
            $product -> addChild('product_ID', $_POST['prodID']);
            $product -> addChild('weight', $_POST['weight']);
            $product -> addChild('price', $_POST['price']);
            $product -> addChild('saleprice', $_POST['salePrice']);
            $product -> addChild('quantity', $_POST['prodQuantity']); 
            $product -> addChild('description', $_POST['description']);
            $product -> addChild('similarID1', $_POST['similar1']);
            $product -> addChild('similarID2', $_POST['similar2']);
            $product -> addChild('similarID3', $_POST['similar3']);
            $product -> addChild('imagename', $target_file);
            move_uploaded_file($_FILES["prodImg"]["tmp_name"],$target_file);
        }
    }
}

function editProd($id){
    global $products;
    $target_file = "../../images/" . basename($_FILES["prodImg"]["name"]);
    foreach($products -> aisle as $aisle){
        foreach($aisle -> product as $product){
            if (strcmp($product['id'], $id) == 0){
                $product -> title = $_POST['prodName'];
                $product -> product_ID = $_POST['prodID'];
                $product -> weight = $_POST['weight'];
                $product -> price = $_POST['price'];
                $product -> saleprice = $_POST['salePrice'];
                $product -> quantity = $_POST['prodQuantity'];
                $product -> description = $_POST['description'];
                $product -> similarID1 = $_POST['similar1'];
                $product -> similarID2 = $_POST['similar2'];
                $product -> similarID3 = $_POST['similar3'];
                $product['class'] = $_POST['prodAisle'];
                if ($_FILES["prodImg"]["size"] > 1000){
                    if(file_exists($product -> imagename)){
                        unlink($product -> imagename);
                    }
                    $product -> imagename = $target_file;
                    move_uploaded_file($_FILES["prodImg"]["tmp_name"],$target_file);
                }

                if (strcmp($product['class'], $aisle['class']) != 0){
                    $product['id'] = idDecider($product['class']);
                    $dm = dom_import_simplexml($product);
                    foreach($products -> aisle as $a){   
                        if (strcmp($a['class'], $product['class']) == 0){
                           $a = dom_import_simplexml($a);
                           $a -> appendChild($dm);
                           break;
                        }
                    }
                }
                return;
            }
        }
    }
}

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($products->asXML());
    $dom->save("../../XML-files/Products.xml");
?>