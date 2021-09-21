class AddProducts{

    static init(){
        $("[name^=size]").val(0);

        $("#add-product-form").validate({
            submitHandler: function (form, event) {
              event.preventDefault();
              AddProducts.addProductInStore(jsonize_form($(form)));
              //checkAndUpdate(jsonize_form($(form)));
            },
          });
    }

  static addProductInStore(details) {
    var stock = {};
    RestClient.post("api/admin/products", details, function (data) {
      stock["product_id"] = data.id;
      for (var size = 1; size < 6; size++) {
        stock["size_id"] = size;
        stock["quantity_avaliable"] = details["size" + size];
        AddProducts.addProductStock(stock);
      }
      toastr.success("Product successfully added");
      document.getElementById("add-product-form").reset();
      $("[name^=size]").val(0);
    });
  }

  static addProductStock(details) {
    RestClient.post("api/admin/products/stock", details, function (data) {});
  }

  static previewProduct() {
    var info = jsonize_form($("#add-product-form"));
    for (var element in info) {
      if (info[element] == "" || info[element] == null) {
        toastr.error("Please enter data for all fields");
        return false;
      }
    }
    $("#product_image").attr("src", info.image_link);
    $("#product_name").html(info.name);
    $("#product_price").html(info.unit_price + ".00 KM");
    AddProducts.setSizesDropdown(info);
  }

  static setSizesDropdown(info) {
    var html = `<option class="dropdown-item" value="1">XS</option>
                <option class="dropdown-item" value="2">S</option>
                <option class="dropdown-item" value="3">M</option>
                <option class="dropdown-item" value="4">L</option>
                <option class="dropdown-item" value="5">XL</option>`;
    $("#product_sizes").html(html);

    for (var i = 1; i < 6; i++) {
      if (info["size" + i] <= 0 || info["size" + i] == null) {
        $("option[value='" + i + "']").remove();
      }
    }
  }


}