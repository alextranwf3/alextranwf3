 function cloneItem() {
      var item = document.getElementById("item");
      var list = document.getElementById("list");
      var clonedItem = item.cloneNode(true);
      list.appendChild(clonedItem);
  }

  for(var i = 1; i < {{hotel.etoile}}; i++) {
    cloneItem();
  }

