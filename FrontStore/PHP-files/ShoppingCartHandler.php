<?php
session_start();
$products_data = simplexml_load_file("../../XML-files/Products.xml") or die("Error. File not found.");
if (!isset($_SESSION['products']) or !isset($_SESSION['quantities'])) {
  $_SESSION['products'] = array();
  $_SESSION['quantities'] = array();
}

function checkIfAlreadyArray($prodID){
	foreach ($_SESSION['products'] as $product){
		$product = new SimpleXMLElement($product);
		if ($product['id'] == $prodID){
			$_SESSION['quantities'][$prodID] += $_GET['qty'];
		return true;
		}
	}
	return false;
}


switch ($_GET['act']) {

  case 'add':
    foreach($products_data -> aisle as $loop_aisle) {
      foreach($loop_aisle -> product as $loop_product) {
        if ($loop_product['id'] == $_GET['id'])  {
			if(!checkIfAlreadyArray($_GET['id'])){
			  $id = (string) $loop_product['id'];
			  $_SESSION['quantities'][$id] = $_GET['qty'];
			  array_push($_SESSION['products'], $loop_product -> asXML());
			}
        }
      }
    }
  break;

  case 'delete':
      foreach($_SESSION['products'] as $key => $loop_product) {
		  $loop_product = new SimpleXMLElement($loop_product);
          if ($loop_product['id'] == $_GET['id']) {
		  $id = $loop_product['id'];
          unset($_SESSION['products'][$key]);
          unset($_SESSION['quantities'][$id]);
        }
      }
  break;

  case 'qtyChange':
		$_SESSION['quantities'][$_GET['id']] = $_GET['qty'];
		break;
}
?>
