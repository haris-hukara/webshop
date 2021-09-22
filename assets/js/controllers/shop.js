class Shop{

static init(){

    setCartCount();
    Shop.default_products();
    
 //   AUtils.role_based_elements();
 //   EmailTemplate.get_all();
 //   EmailTemplate.chart();
  }

  // loadDefaultProducts = default_products
  // loadProducts = get_products
  // setTotalRecordsOfSearch = set_total_records_for_search
  // createPaggination = set_paggination
  // getPagesCount get_number_of_pages

  static default_products() {
    var a ="";
    Shop.get_products(0,5,a ,"-name");
    Shop.set_total_records_for_search("");
    Shop.set_paggination(Shop.get_total_records(), 5);
    Shop.change_page_button_style(1);
  }
  
  static set_total_records_for_search(search) {
    RestClient.get(("api/products_count?search="+search), function (data) {
        localStorage.setItem("total_records",JSON.parse(data.avaliable_products));
      });
  }

  static get_total_records() {
    return JSON.parse(localStorage.getItem("total_records"));
  }

  static get_number_of_pages(total_records, records_per_page) {
    var numOfPages = total_records / records_per_page;
    return Math.ceil(numOfPages);
  }
  
  static set_paggination(total_records, records_per_page) {
    var len = Shop.get_number_of_pages(total_records, records_per_page);
    var html = "";
    var offset = 0;

    for (var p = 1; p < len + 1; p++) {
      html +=
        `<button id="page`+p+`" onclick="Shop.load_page(`+parseInt(offset)+`,`+records_per_page+`)" data-aos="fade-down" type="button" class="btn page-default"">`+p+`</button>`;
      offset += parseInt(records_per_page);
    }
    $("#pagination").html(html);
  }

  //getProductSizes
  static get_product_sizes(product_id, html_id) {
    RestClient.get("api/product/avaliable_sizes/"+product_id, function (data) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
          html += `"<option class="dropdown-item" value="`+data[i].size_id+`">`+data[i].name+`</option>"`;
        }
        $("#size" + html_id).html(html);
      });
  }

  static get_products(offset = 0, limit = 10, search = "", order = "%2bid") {
    RestClient.get("api/products?offset="+offset 
                              +"&limit="+limit
                              +"&search="+search
                              +"&order="+order, function (data) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
          html +=
            `<div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                   <div class="block-4 text-center border">
                    <figure class="block-4-image">
                    <a><img
                        id="picture-p`+i+`"
                        class="product_picture"
                        src="`+data[i].image_link+`"
                        alt="Product image" class="img-fluid"/></a>
                    </figure>
                  <div class="block-4-text p-4">
                    <h3><p id="name-p`+i+`">`+data[i].name+`</p></h3>
                    <p class="text-primary font-weight-bold mb-3 h5">`+data[i].unit_price+`.00 KM</p>
                      <select id="size`+i+`" class="btn btn btn-secondary">`+Shop.get_product_sizes(data[i].id, i)+`</select>
                      <button onclick="Shop.add_product(`+data[i].id+`,`+i+`,1)" type="button" class="btn" style="border-radius: 0.2em; margin-left: 0.5em; background-color: #7971ea; color: white;">Add to Cart</button>
              </div></div></div></div>`;
        }
        $("#data-load").html(html);
      }
  )
  }
  static get_stored_search() {
    return JSON.parse(localStorage.getItem("search"))[0];
  }

  static load_page(offset, limit) {
    if(localStorage.getItem("search") == null){
       localStorage.setItem("search",'[{"order_by":"-name","per_page":"5","search":""}]')
    }
    Shop.get_products(offset,limit,Shop.get_stored_search().search, Shop.get_stored_search().order_by);
    var page = (parseInt(limit)/parseInt(offset)) + 1;
    if(offset == 0){page = 1};
    Shop.change_page_button_style(page);
  }

  static change_page_button_style(page){
    $('[id^=page]').addClass("page-default");
    $(`[id=page`+page+"]").removeClass("page-default");
    $(`[id=page`+page+"]").addClass("active-page");
  }

  static search_products() {
    Shop.set_total_records_for_search(getElementValue("product_search"));

    let search = [];
    search.push({order_by: getDropdownValue("sort"),
      per_page: getDropdownValue("per_page"),
      search: getElementValue("product_search"),
    });

    localStorage.setItem("search", JSON.stringify(search));

    Shop.get_products(
      0,
      getDropdownValue("per_page"),
      getElementValue("product_search"),
      getDropdownValue("sort")
    );

    $("#pagination").html("");

    setTimeout(function () {
      Shop.set_paggination(Shop.get_total_records(), Shop.get_stored_search().per_page);
    }, 1000);
  }

  static add_product(product_id, position, quantity) {
    var size_id = getSizeId("size" + position);
    var size_name = getSizeName("size" + position);
    var product_name = document.getElementById("name-p"+position).innerHTML;
    var product_picture = $("#picture-p"+position).attr('src');

    if (getCart() == false) {
      document.getElementById("count").setAttribute("hidden", "true");
      setCartEmpty();
    }

    if (Shop.product_in_cart(product_id, size_id) !== false) {
      var product_index = Shop.product_in_cart(product_id, size_id);
      var new_quantity = Shop.get_product_cart_quantity(product_index) + quantity;
      Shop.remove_product(product_index);
      Shop.add_product(product_id, position, new_quantity);
    } else {
      let products = [];
      if (localStorage.getItem("products")) {
        products = JSON.parse(getCart());
      }
      products.push({
        product_name:product_name,
        product_id: product_id,
        size_name: size_name,
        size_id: size_id,
        quantity: quantity,
        product_picture: product_picture
      });
      localStorage.setItem("products", JSON.stringify(products));
     
      toastr.success( "Product: " + product_name + " Size: " + size_name + " is added to cart");
      // change cart icon count
      setCartCount();
    }
  }

  static remove_product(index) {
    var storageProducts = JSON.parse(getCart());
    storageProducts.splice(index, 1);
    var products = storageProducts;
    localStorage.setItem("products", JSON.stringify(products));
    setCartCount();
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

}
