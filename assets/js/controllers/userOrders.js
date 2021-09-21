class UserOrders{

static init(){
    UserOrders.load();
}

static load_details(order_id){
  RestClient.get("api/user/order/details/"+order_id,  function(data){
      var html ="";
      for (var i = 0; i < data.length; i++){
        html += ` <tr>
            <td class="product-thumbnail d-flex justify-content-center">
              <img style="width: 80px" src="`+data[i].image_link+`" alt="Image" class="img-fluid"></td>
            <td><h2 class="h5 text-black">`+data[i].product_name+`</h2></td>
            <td><h2 class="h5 text-black">`+data[i].size+`</h2></td>
            <td>`+data[i].unit_price+`.00 KM</td>
            <td>`+data[i].quantity+`</td>
            <td id="details-total-p`+i+`">`+data[i].total+`.00 KM</td></tr>`;
      }
      html+= `<tr><td></td><td></td><td></td><td></td><td></td>
              <td id="details-total" class="h5">Total: </td></tr>`
      $("#details_table").html(html);
      $("#order_id").html("Order ID: "+ order_id);
      document.getElementById("order-details").removeAttribute("hidden");
    })
  
    setTimeout(function () {UserOrders.load_total_price(order_id);}, 1500);
  
}

static load(){
  RestClient.get("api/user/orders",function(data){
      var html ="";
      for (var i = (data.length)-1; i > -1 ; i--){
        html += ` <tr><td id="my-order-id`+i+`">`+data[i].id+`</td>
                  <td id="my-order-address`+i+`">`+data[i].shipping_address+`</td>
                  <td id="my-order-status`+i+`">`+data[i].status+`</td>
                  <td id="my-order-date`+i+`">`+data[i].order_date+`</td>
                  <td id="id="my-order-details`+i+`">
                  <button onclick="UserOrders.load_details(`+data[i].id+`)" class="btn" style="margin-top:1em; border-radius: 0.2em; width: 100%; background-color: #7971ea; color: white;">See order details</button>
                  </td></tr>`;
      }
      $("#my_orders").html(html);
      })
  }

static load_total_price(order_id){
  RestClient.get("api/user/order/details/price/"+order_id, function(data){
      $("#details-total").html("Total: " + data[0].total_price +".00 KM");
    })
}
}