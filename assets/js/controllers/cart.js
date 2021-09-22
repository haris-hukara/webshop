class Cart{

  static init(){
    setCartCount();
    Cart.create_cart();
  }

  static get_product_cart_quantity(storage_index) {
    return JSON.parse(getCart())[storage_index].quantity;
  }

  static product_in_cart(product_id, size_id) {
    var cart = JSON.parse(getCart());
    for (var i = 0; i < cart.length; i++) {
      if (cart[i].product_id == product_id && cart[i].size_id == size_id) {
        return i;
      }
    }
    return false;
  }

  static get_product_from_cart(position){
    return JSON.parse(getCart())[position];
  }

  static add_product(product_info){
    let products = [];
    if (localStorage.getItem("products")) {
      products = JSON.parse(getCart());
    }
    products.push({
      product_name:product_info["product_name"],
      product_id: product_info["product_id"],
      size_name: product_info["size_name"],
      size_id: product_info["size_id"],
      quantity: product_info["quantity"],
      product_picture: product_info["product_picture"]
    });
    localStorage.setItem("products", JSON.stringify(products));
  }

  
  static decrement_product_quantity(position){
    Cart.change_product_quantity(position, (-1));
    Cart.create_cart();
  }
  static increment_product_quantity(position){
    Cart.change_product_quantity(position, 1);
    Cart.create_cart();
  }
  
  
  static change_product_quantity(position, by_quantity) {
    
    var product_info={};
    if (Cart.get_product_from_cart(position) != undefined){
      product_info["product_name"] = Cart.get_product_from_cart(position).product_name;
      product_info["product_id"] = Cart.get_product_from_cart(position).product_id;
      product_info["size_id"] =  Cart.get_product_from_cart(position).size_id; 
      product_info["size_name"] = Cart.get_product_from_cart(position).size_name;
      product_info["product_picture"] = Cart.get_product_from_cart(position).product_picture;
      product_info["quantity"] = Cart.get_product_from_cart(position).quantity;
  
     var this_position = Cart.product_in_cart(product_info["product_id"], product_info["size_id"]);
    
      if (this_position !== false ){
      Cart.remove_product(this_position);
      product_info["quantity"] += by_quantity;
          
          if(product_info["quantity"]!=0){
              Cart.add_product(product_info);
          }
        
                if (getCart() == false) {
                  document.getElementById("count").setAttribute("hidden", "true");
                  setCartEmpty();
                }
      }
   }
    setCartCount();
  }


  static remove_product(index){
      var storageProducts = JSON.parse(getCart());
      storageProducts.splice(index, 1);
      var products = storageProducts;
      localStorage.setItem('products', JSON.stringify(products));
      setCartCount();
  }
 
  static remove_from_cart(product_id){
    var product_name = JSON.parse(getCart())[product_id].product_name;
    var product_size = JSON.parse(getCart())[0].size_name;
    Cart.remove_product(product_id);
    toastr.success( "Product: " + product_name + " Size: " + product_size + " is removed from cart");
    Cart.create_cart();
  }  

  static calculate_product_total(html_id){
  var unit_price = document.getElementById("unit-p"+html_id).innerHTML;
  var quantity = document.getElementById("quantity-p"+html_id).value;
  return (parseInt(unit_price) * quantity); 
}

 static create_cart(){
   var html=""
  for ( var i = 0; i < getLocalStorage("products").length; i++){
             html +=`
                    <tr>
                      <td class="product-thumbnail">
                        <img style="width:80px"src="`+getLocalStorage("products")[i].product_picture+`" alt="Image" class="img-fluid">
                      </td>
                      <td class="product-name">
                      <p id="product-id-p`+i+`" hidden>`+getLocalStorage("products")[i].product_id+`</p> 
                        <h2 class="h5 text-black">`+getLocalStorage("products")[i].product_name+`</h2>
                      </td>
                      <td class="product-size">
                        <h2 class="h5 text-black">`+getLocalStorage("products")[i].size_name+`</h2>
                      </td>
                      <td id="unit-p`+i+`">`+Cart.set_unit_price(i,getLocalStorage("products")[i].product_id)+`.00 KM</td>
                      <td>
                        <div class="input-group mb-3" style="max-width: 120px">
                          <div class="input-group-prepend">
                            <button onClick="Cart.decrement_product_quantity(`+i+`)" class="btn btn-outline-primary js-btn-minus" type="button">
                              −
                            </button>
                          </div>
                          <input disabled id="quantity-p`+i+`" type="text" class="form-control text-center" value="`+getLocalStorage("products")[i].quantity+`" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                          <div class="input-group-append">
                            <button onClick="Cart.increment_product_quantity(`+i+`)" class="btn btn-outline-primary js-btn-plus" type="button">
                              +
                            </button>
                          </div>
                        </div>  
                      </td>
                      <td id="total-p`+i+`">00.00 KM</td>
                      <td> <button onClick="Cart.remove_from_cart(`+i+`)" data-aos="fade-down" type="button" class="btn aos-init aos-animate" style="border-radius: 0.2em; margin: 0.5em; background-color: #7971ea; color: white;">X</button>
                  </td>
                    </tr>`

                  }
                $("#cart_table").html(html);
                setTimeout(function () {
                  for ( var i = 0; i < getLocalStorage("products").length; i++){
                  $("#total-p"+i).html(Cart.calculate_product_total(i) +".00 KM");
                  }
                }, 1500);
                setTimeout(function () {Cart.calcute_total()},1500);
                
                }

    
   static calcute_total(){
     var total = 0;
    for ( var i = 0; i < getLocalStorage("products").length; i++){
                  total += parseInt(document.getElementById("total-p"+i).innerHTML);
                }
                $("#total_amount").html(total+".00 KM");
    }
    
   static set_unit_price(html_index,product_id){
    RestClient.get("api/product/"+product_id, function(data){
      $("#unit-p"+html_index).html(data.unit_price +".00 KM");
    })
   }


  static go_to_checkout(){
    if ((JSON.parse(getCart()).length) == 0 ) 
    {
      window.location = ("#shop");
      toastr.error("Your cart is empty, buy something");
    }  else{
      window.location = ("#checkout");
    }
  }    

  
}
