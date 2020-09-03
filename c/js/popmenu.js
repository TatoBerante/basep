function popMenu() {
  var divmenu = document.getElementById("popmenu");
  var burgericon = document.getElementById("burgericon");
  var mainheader = document.getElementById("mainheader");
  var headerdevider = document.getElementById("headerdevider");
  if(divmenu.style.display == "block") {
    divmenu.style.display = "none";
    burgericon.src = 'img/burger-icon.png';
    headerdevider.style.display = "block";
  }
  else {
    divmenu .style.display = "block";
    burgericon.src = 'img/burger-x.png';
    headerdevider.style.display = "none";
  }
}
