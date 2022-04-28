
let products = document.getElementsByClassName("productrow");
const xhttp = new XMLHttpRequest();
eventListeners();

function eventListeners(){
    Array.from(products).forEach(function(product){
    calculateItemPrice(product)
    product.querySelector(".qty.text").addEventListener('change', function(){
        calculateItemPrice(product);
		xhttp.open("GET", ("OrderEditProductQty.php?act=edit&prodID=" + product.id + "&order=" + document.getElementById("orderID").value + "&qty=" + product.querySelector(".qty.text").value));
		xhttp.send();
    })
    product.querySelector(".removebtn").addEventListener('click', function(){
        deleteItemRow(product)
    })
    product.querySelector(".plus").addEventListener('click', function(){
        incrementQty(product);
    })
    product.querySelector(".minus").addEventListener('click', function(){
        decrementQty(product);
    })
})
}

function calculateOrderSummary(){
    let prodPrices = document.getElementsByClassName("totalProdPrice");
    let subtotal  =  0;

    for(let i =  0; i < prodPrices.length; i++){
        subtotal += parseFloat(prodPrices[i].textContent.substring(1));
    }

    subtotal = parseFloat(subtotal.toFixed(2));
    total = (subtotal).toFixed(2);

    document.querySelector("#total").value = total;
}

function calculateItemPrice(product){
    let qty = product.querySelector(".qty.text");

    if (qty.value < 0 || qty.value == "")
        product.querySelector(".qty.text").value = 0;
    if (qty.value > 100)
        qty.value = 100;

    let quantity = parseInt(qty.value);
    let originalPrice = parseFloat(product.querySelector(".prodPrice").innerText.substring(1));
    let newPrice = parseFloat((originalPrice*quantity).toFixed(2));
    product.querySelector(".totalProdPrice").innerText = "$" + newPrice;
    calculateOrderSummary();
}

function deleteItemRow(product){
    product.remove();
    calculateOrderSummary();
	xhttp.open("GET", ("OrderEditProductQty.php?act=delete&prodID=" + product.id  + "&order=" + document.getElementById("orderID").value) + "&total=" + document.getElementById("total").value);
	xhttp.send();
}

function incrementQty(product){
    let qty = product.querySelector(".qty.text");
    let previousQty = parseInt(qty.value);
    qty.value = previousQty + 1;
    qty.dispatchEvent(new Event('change'));
	xhttp.open("GET", ("OrderEditProductQty.php?act=edit&prodID=" + product.id+ "&qty=" + qty.value + "&order=" + document.getElementById("orderID").value + "&total=" + document.getElementById("total").value));	
	xhttp.send();
}

function decrementQty(product){
    let qty = product.querySelector(".qty.text");
    let previousQty = parseInt(qty.value);

    if (qty.value - 1 < 0)
        qty.value = 0
    else
        qty.value = previousQty - 1;

    qty.dispatchEvent(new Event('change'));
	xhttp.open("GET", ("OrderEditProductQty.php?act=edit&prodID=" + product.id+ "&qty=" + qty.value + "&order=" + document.getElementById("orderID").value + "&total=" + document.getElementById("total").value));
	xhttp.send();
}

let prodTable = document.getElementById("tableBody");
const sender = new XMLHttpRequest();

var addProdBtn = document.getElementById("modalAddBtn");
let tableOriginal;
let tableNew;

sender.onload = function() {
    response = sender.responseText;
    let receivedOrderID = response.substr(0, response.indexOf("\n"));
    if(receivedOrderID != ""){
        document.getElementById("orderID").value = receivedOrderID;
    }
    response = response.substr(response.indexOf("\n") + 1);
    if (response === "false"){
        alert("Error: Product not found");
        return;
    }

   tableOriginal = prodTable.innerHTML;
   tableNew = tableOriginal + response;
   prodTable.innerHTML = tableNew;
    eventListeners();
}

addProdBtn.addEventListener('click', function(){
    let prodID = document.getElementById("modalProdID").value;
    let orderID = document.getElementById("orderID").value;
    sender.open("GET", "addProdToOrder.php?prodID=" + prodID + "&orderID=" + orderID);
    sender.send();
});


function addProd(){
    let prodID = document.getElementById("modalProdID").value;
    let orderID = document.getElementById("orderID").value;
    sender.open("GET", "addProdToOrder.php?prodID=" + prodID + "&orderID=" + orderID);
    sender.send();
}

