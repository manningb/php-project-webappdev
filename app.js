function showHide(itemID) {
    // show hide all other elements other than the current selected one.
    item = document.getElementById(itemID);
    prevShown = document.getElementsByClassName("visible");
    if (prevShown.length > 0 && prevShown[0] != item){
        prevShown[0].className = "hidden";
    }
    if (item.className === "hidden") {
        item.className = "visible";
      } else {
        item.className = "hidden";
      }
}

function showCustInfo(custNum) {
    // show hide all other elements other than the current selected one.
    item = document.getElementById(custNum);
    console.log(custNum);
    if (item.className === "hidden") {
        item.className = "visible";
      } else {
        item.className = "hidden";
      }
}