//QUANTITY BUTTON SECTION
var minus = document.querySelector('.minus');
var plus = document.querySelector('.plus');
var mousedownID = -1;
var original_price = parseFloat(document.querySelector('.price-value').innerHTML);
var original_old_price = parseFloat(document.querySelector('.newoldprice').innerHTML);
var location;
const xhttp = new XMLHttpRequest();
let prodID = document.querySelector(".product-box").id;

if (localStorage.location != window.location.href) {
localquantity = 1;
localStorage.setItem('localquantity', 1);
localprice = original_price;
localStorage.setItem('localprice', original_price);
localoldprice = original_old_price;
localStorage.setItem('localoldprice', original_old_price);
location = window.location.href;
}
localStorage.setItem("location", location);

localquantity = localStorage.getItem('localquantity');
localprice = localStorage.getItem('localprice');
localoldprice = localStorage.getItem('localoldprice');
localunit = localStorage.getItem('localunit');
localoldunit = localStorage.getItem('localoldunit');

if (localquantity == null) {
  localquantity = 1;
  localStorage.setItem('localquantity', 1);
}

if (localprice == null) {
  localprice = original_price;
  localStorage.setItem('localprice', original_price);
}

if (localoldprice == null) {
  localoldprice = original_old_price;
  localStorage.setItem('localoldprice', original_old_price);
}

if (localquantity == 1) {
  localStorage.setItem('localunit', "unit");
  localStorage.setItem('localoldunit', "unit");
}
if (localquantity != 1) {
  localStorage.setItem('localunit', (localquantity+" units"));
  localStorage.setItem('localoldunit', (localquantity+" units"));
}

document.querySelector('.price-value').innerHTML = localStorage.getItem('localprice');
document.querySelector('.qty').value = localStorage.getItem('localquantity');
document.querySelector('.newoldprice').innerHTML = localStorage.getItem('localoldprice');
document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');


plus.addEventListener('click', incrementQty);
minus.addEventListener('click', decrementQty);
plus.addEventListener('mousedown', incrementHoldQty);
minus.addEventListener('mousedown', decrementHoldQty);
minus.addEventListener('mouseup', mouseup);
plus.addEventListener('mouseup', mouseup);

function incrementQty() {
  if (parseInt(localquantity)<document.querySelector('.qty').max) {
    localquantity = parseInt(localquantity) + 1;
    localStorage.setItem('localquantity', localquantity);
    document.querySelector('.qty').value = localStorage.getItem('localquantity');

    localprice = parseFloat(localquantity*original_price).toFixed(2);
    localStorage.setItem('localprice', localprice);
    document.querySelector('.price-value').innerHTML = localStorage.getItem('localprice');

    localoldprice = parseFloat(localquantity*original_old_price).toFixed(2);
    localStorage.setItem('localoldprice', localoldprice);
    document.querySelector('.newoldprice').innerHTML = localStorage.getItem('localoldprice');
  }
  if (localquantity != 1) {
    localunit = localquantity+" units";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = localquantity+" units";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
  if (localquantity == 1) {
    localunit = "unit";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = "unit";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }

}

function incrementHoldQty() {
  while (mousedownID == -1 && parseInt(localquantity)<document.querySelector('.qty').max) {
    mousedownID = setInterval(incrementHoldFunction, 100);
  }
}

function incrementHoldFunction() {
  if (parseInt(localquantity)<document.querySelector('.qty').max) {
    localquantity = parseInt(localquantity) + 1;
    localStorage.setItem('localquantity', localquantity);
    document.querySelector('.qty').value = localStorage.getItem('localquantity');

    localprice = parseFloat(localquantity*original_price).toFixed(2);
    localStorage.setItem('localprice', localprice);
    document.querySelector('.price-value').innerHTML = localStorage.getItem('localprice');

    localoldprice = parseFloat(localquantity*original_old_price).toFixed(2);
    localStorage.setItem('localoldprice', localoldprice);
    document.querySelector('.newoldprice').innerHTML = localStorage.getItem('localoldprice');
  }
  if (localquantity != 1) {
    localunit = localquantity+" units";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = localquantity+" units";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
  if (localquantity == 1) {
    localunit = "unit";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = "unit";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
}

function decrementQty() {
  if (parseInt(localquantity)>document.querySelector('.qty').min) {
    localquantity = parseInt(localquantity) - 1;
    localStorage.setItem('localquantity', localquantity);
    document.querySelector('.qty').value = localStorage.getItem('localquantity');

    localprice = parseFloat(localquantity*original_price).toFixed(2);
    localStorage.setItem('localprice', localprice);
    document.querySelector('.price-value').innerHTML = localStorage.getItem('localprice');

    localoldprice = parseFloat(localquantity*original_old_price).toFixed(2);
    localStorage.setItem('localoldprice', localoldprice);
    document.querySelector('.newoldprice').innerHTML = localStorage.getItem('localoldprice');
  }
  if (localquantity != 1) {
    localunit = localquantity+" units";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = localquantity+" units";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
  if (localquantity == 1) {
    localunit = "unit";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = "unit";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
}

function decrementHoldQty() {
  while (mousedownID == -1 && parseInt(localquantity)>document.querySelector('.qty').min) {
    mousedownID = setInterval(decrementHoldFunction, 100);
  }
}

function decrementHoldFunction() {
  if (parseInt(localquantity)>document.querySelector('.qty').min) {
    localquantity = parseInt(localquantity) - 1;
    localStorage.setItem('localquantity', localquantity);
    document.querySelector('.qty').value = localStorage.getItem('localquantity');

    localprice = parseFloat(localquantity*original_price).toFixed(2);
    localStorage.setItem('localprice', localprice);
    document.querySelector('.price-value').innerHTML = localStorage.getItem('localprice');

    localoldprice = parseFloat(localquantity*original_old_price).toFixed(2);
    localStorage.setItem('localoldprice', localoldprice);
    document.querySelector('.newoldprice').innerHTML = localStorage.getItem('localoldprice');
  }
  if (localquantity != 1) {
    localunit = localquantity+" units";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = localquantity+" units";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
  if (localquantity == 1) {
    localunit = "unit";
    localStorage.setItem('localunit', localunit);
    document.querySelector('.unit').innerHTML = localStorage.getItem('localunit');
    if (localoldprice != null) {
      localoldunit = "unit";
      localStorage.setItem('localoldunit', localoldunit);
      document.querySelector('.oldunit').innerHTML = localStorage.getItem('localoldunit');
    }
  }
}

function mouseup() {
   if(mousedownID!=-1) {  //Only stop if exists
     clearInterval(mousedownID);
     mousedownID=-1;
   }
 }


 //ADD TO CART SECTION
 var popup = document.querySelector('.cart');
 var product = document.querySelector('.product-title');
 popup.addEventListener('click', popupMsg);

 function popupMsg() {
  alert("Your order has been added to the cart!\n\n"+orderMsg()+savedmoney());
 }

 function orderMsg() {
  if (localquantity == 1)
    return localquantity +' '+product.title+' added to cart for $'+ localprice+'.';
  else
    return localquantity +' '+product.title+'s added to cart for $'+ localprice+'.';
 }

 function savedmoney() {
   if (original_old_price != null) {
    var savedmoney = parseFloat(localoldprice - localprice).toFixed(2);
    return "\n\nYou saved $"+savedmoney+"!";
   }
   else {
     return "";
   }
 }

let addBtn = document.querySelector('[name="addToCart"]');
 addBtn.addEventListener('click', addToCart);

function addToCart(){
	xhttp.open("GET",("ShoppingCartHandler.php?act=add&id=" + prodID + "&qty=" + document.querySelector('.input-text.qty').value));
	xhttp.send();
}
