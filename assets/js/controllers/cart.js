class Cart{

  static init(){
    setCartCount();
    Cart.create_cart();
    
 //   AUtils.role_based_elements();
 //   EmailTemplate.get_all();
 //   EmailTemplate.chart();
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
                        <h2 class="h5 text-black">`+getLocalStorage("products")[i].product_name+`</h2>
                      </td>
                      <td class="product-size">
                        <h2 class="h5 text-black">`+getLocalStorage("products")[i].size_name+`</h2>
                      </td>
                      <td id="unit-p`+i+`">`+Cart.set_unit_price(i,getLocalStorage("products")[i].product_id)+`.00 KM</td>
                      <td>
                        <div class="input-group mb-3" style="max-width: 120px">
                          <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">
                              −
                            </button>
                          </div>
                          <input id="quantity-p`+i+`" type="text" class="form-control text-center" value="`+getLocalStorage("products")[i].quantity+`" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                          <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">
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
    
    $.ajax({
          url:"api/product/"+product_id,
          type:"GET",
          success: function(data){
            $("#unit-p"+html_index).html(data.unit_price +".00 KM");
          }
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
