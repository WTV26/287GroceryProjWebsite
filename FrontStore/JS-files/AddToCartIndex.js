//ADD TO CART SECTION
function popupMsg(card_title) {
 alert("1 "+card_title+" has been added to the cart!");
}

let cardArray = document.getElementsByClassName('card');
const xhttp = new XMLHttpRequest();

Array.from(cardArray).forEach(function(card){
	addBtn = card.querySelector('.addToCart');
    addBtn.addEventListener('click', function(){
      console.log('bruh');
		xhttp.open("GET", ("./FrontStore/PHP-files/ShoppingCartHandler.php?act=add&id=" + card.querySelector('.addToCart').id + "&qty=1"));
	    xhttp.send();
    })

	addBtn.addEventListener('click', function(){
		card_title = card.querySelector('.card-title').innerText;
	     popupMsg(card_title);})
})
