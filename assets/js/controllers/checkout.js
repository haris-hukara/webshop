class Checkout{

  static init(){
    Checkout.load_user_details(parse_jwt(window.localStorage.getItem("token")).id);
    $("#checkout-detail-form").validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        Checkout.post_user_details(jsonize_form($(form)));
      },
    });
  
    $("#account-checkout-detail-form").validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        Checkout.post_account_order(jsonize_form($(form)));
      },
    });
  }


  static show_my_form(){
    document.getElementById("other-info-form").setAttribute("hidden", "true");
    document.getElementById("my-info-form").removeAttribute("hidden");
  }
  
  static show_other_form(){
    document.getElementById("my-info-form").setAttribute("hidden", "true");
    document.getElementById("other-info-form").removeAttribute("hidden");
  }

  static post_account_order(details){
    var account_id = parse_jwt(window.localStorage.getItem("token")).id;
    RestClient.get("api/user/account/"+account_id, function(data){
      Checkout.post_order(details, data.user_details_id);
            });
  }
  
  static make_order(details){
    Checkout.post_user_details(details);
    setTimeout(function () {post_order(details);},2000);

    if((JSON.parse(document.getElementById("user_order_id").innerHTML)) === 5){
      setTimeout(function () {Checkout.post_order_details(JSON.parse(getCart()));},4000);  
    }
    setTimeout(function () {Checkout.post_order_details(JSON.parse(getCart()));},5000); 
    
  }


  static post_user_details(user_details){
    RestClient.post("api/details/add",user_details, function(data){
      Checkout.post_order(user_details, data.id);
          });
      }
 
    
   static post_order(details, details_id){
    
    var order ={};
    order["user_details_id"] = details_id;
    order["shipping_address"] = details.shipping_address;
    order["payment_method_id"] = details.payment_method;
    order["status"] = "ACTIVE";
    RestClient.post("api/order",order,function(data){
      Checkout.post_order_details(JSON.parse(getCart()), data.id);
          });
      }

  
      static post_order_details(cart, order_id){
    var order_details ={};

   for(var i = 0; i < cart.length; i++){
    
    order_details["order_id"] = order_id;
    order_details["product_id"] = cart[i].product_id;
    order_details["size_id"] = cart[i].size_id;
    order_details["quantity"] = cart[i].quantity;

    RestClient.post("api/order/details",order_details,function(data){});
    }
      window.location  = ("#thankyou");
      setCartEmpty();
      setCartCount();
    }


    static load_user_details(account_id){
      RestClient.get("api/user/details/"+account_id, function(data){
        document.getElementById("u_name").setAttribute("placeholder", data.name);
        document.getElementById("u_surname").setAttribute("placeholder", data.surname);
        document.getElementById("u_email_address").setAttribute("placeholder", data.email);
        document.getElementById("u_phone").setAttribute("placeholder", data.phone_number);
        document.getElementById("u_city").setAttribute("placeholder", data.city);
        document.getElementById("u_postal_zip").setAttribute("placeholder", data.zip_code);
        document.getElementById("u_address").setAttribute("placeholder", data.address);
    })
  }

}









