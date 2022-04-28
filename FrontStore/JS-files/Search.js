//MAIN SEARCHBAR
var searchbar = document.querySelector('.searchbar');
var searchbar_drop = document.querySelector('.searchbar_drop');
var searchbar_dropdown = document.getElementById('searchbar_dropdown');
var products = [];
//products = document.querySelectorAll();

searchbar.addEventListener('keyup', search);
searchbar.addEventListener('click', showDropdown);

function showDropdown() {
  console.log(searchbar_drop);
  searchbar_drop.style.visibility = 'visible';
  document.body.addEventListener('click', function() {searchbar_drop.style.visibility = 'hidden'}, true);
}

function search(e) {
  var searchString = e.target.value.toLowerCase();
  console.log(e.target.value);
  var filtered_products = Object.values(products).filter(function(product) {return product.innerText.toLowerCase().includes(searchString)});
  console.log(filtered_products);
  for (var i=0; i<3;i++)
  searchbar_dropdown[i].innerHTML = filtered_products[i];
}













//AISLE Searchbar
// var aisle_search = document.querySelector('.aisle-searchbar');
// var aisle_searchString;
//
// aisle_search.addEventListener('keyup', aislesearch);
//
// function aislesearch(e) {
//   aisle_searchString = e.target.value.toLowerCase();
//   console.log(e.target.value);
//   var filtered_products = Object.values(aisle_products).filter(function(aisle_product) {return aisle_product.innerText.toLowerCase().includes(aisle_searchString)});
//   console.log(filtered_products);
// }
//
//
// var aisle_products = [];
// aisle_products = document.querySelectorAll('.card-title');



// window.onload-function(){
//   var SearchResult - document.getElementById("SearchResult");
//   document.onclick-function(event){
//     if(event.target.id !== 'SearchResult'){
//       SearchResult.style.display "block";
//     }
//     if(event.target.id !== 'SearchInput'){
//       SearchResult.style.display - "none";
//     }
//   }
// }
