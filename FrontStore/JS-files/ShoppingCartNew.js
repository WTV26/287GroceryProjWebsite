
let products = document.getElementsByClassName("productrow");
const gstRate = 0.05;
const qstRate = 0.09975;
const xhttp = new XMLHttpRequest();


Array.from(products).forEach(function(product){

    product.querySelector(".qty.text").addEventListener('change', function(){
        calculateItemPrice(product);
		xhttp.open("GET", ("?act=qtyChange&id=" + product.id+ "&qty=" + product.querySelector(".qty.text").value));
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

function calculateOrderSummary(){
    let prodPrices = document.getElementsByClassName("totalProdPrice");
    let gst, qst, total;
    let subtotal  = 0;

    for(let i =  0; i < prodPrices.length; i++){
        subtotal += parseFloat(prodPrices[i].textContent.substring(1));
    }

    subtotal = parseFloat(subtotal.toFixed(2));
    gst = parseFloat((subtotal * gstRate).toFixed(2));
    qst = parseFloat((subtotal * qstRate).toFixed(2));
    total = (subtotal + qst + gst).toFixed(2);

    document.querySelector("#subtotal").innerText = "Subtotal: $" + subtotal;
    document.querySelector("#gst").innerText = "GST: $" + gst;
    document.querySelector("#qst").innerText = "QST: $" + qst;
    document.querySelector("#total").innerText = "Total: $" + total;
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
	xhttp.open("GET", ("ShoppingCartHandler.php?act=delete&id=" + product.id));
	xhttp.send();
}

function incrementQty(product){
    let qty = product.querySelector(".qty.text");
    let previousQty = parseInt(qty.value);
    qty.value = previousQty + 1;
    qty.dispatchEvent(new Event('change'));
	xhttp.open("GET", ("ShoppingCartHandler.php?act=qtyChange&id=" + product.id+ "&qty=" + qty.value));
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
	xhttp.open("GET", ("ShoppingCartHandler.php?act=qtyChange&id=" + product.id+ "&qty=" + qty.value));
	xhttp.send();
}
