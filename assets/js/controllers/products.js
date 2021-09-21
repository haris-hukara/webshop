class Products{

    static init(){
      Products.getProducts();
        $("#update-product").validate({
            submitHandler: function (form, event) {
              event.preventDefault();
              Products.updateProduct(jsonize_form($(form)));
              //checkAndUpdate(jsonize_form($(form)));
            },
          });
          
    $("#product-stock-update").validate({
        submitHandler: function (form, event) {
          event.preventDefault();
          Products.updateProductStock(jsonize_form($(form)));
        },
      });
    }

    

  static editProduct(id) {
      RestClient.get("api/admin/products/"+id, function(data){
      json2form("#update-product", data);
      $("#edit-product-modal").modal("show");
    });
    }

  static updateProduct(details) {
    RestClient.put("api/admin/products/" + details.id, details, function (data) {
      toastr.success("Product successfully updated");
      Products.getProducts();
      $("#edit-product-modal").trigger("reset");
      $("#edit-product-modal").modal("hide");
    });
  }



  
  static editProductStock(id) {
    RestClient.get("api/products/stock/"+(id), function(data){
        $("[name^=size-]").val(0);
        $("[name^=product_id]").val(id);
        for(var i = 0; i < data.length; i++){
            $(`[name=size-`+data[i].size_id+`]`).val(data[i].quantity_avaliable);
        }
      $("#product-stock-modal").modal("show");
    });
    }
  
 static updateProductStock(details) {
    var stock = {};
    var id = details.product_id;
     for(var i = 1; i < 6; i++){
        stock["size_id"] = i;
        stock["quantity_avaliable"] = parseInt(details["size-" + i]);
        RestClient.put("api/admin/product/stock/"+id,stock, function (data) {});
    }
      $("#product-stock-modal").trigger("reset");
      $("#product-stock-modal").modal("hide");
      toastr.success("Product stock successfully updated");
  }
    

    static getProducts() {
      $("#products-table").DataTable({
        processing: true,
        serverSide: true,
        bDestroy: true,
        pagingType: "simple",
        preDrawCallback: function (settings) {
          if (settings.aoData.length < settings._iDisplayLength) {
            //disable pagination
            settings._iRecordsTotal = 0;
            settings._iRecordsDisplay = 0;
          } else {
            //enable pagination
            settings._iRecordsTotal = 100000000;
            settings._iRecordsDisplay = 1000000000;
          }
        },
        responsive: true,
        language: {
          zeroRecords: "Nothing found - sorry",
          info: "Showing page _PAGE_",
          infoEmpty: "No records available",
          infoFiltered: "",
        },
        ajax: {
          url: "api/admin/products",
          type: "GET",
          beforeSend: function (xhr) {
            xhr.setRequestHeader(
              "Authentication",
              localStorage.getItem("token")
            );
          },
          dataSrc: function (resp) {
            return resp;
          },
          data: function (d) {
            d.offset = d.start;
            d.limit = d.length;
            d.search = d.search.value;
            d.order =
              (d.order[0].dir == "asc" ? "-" : "+") +
              d.columns[d.order[0].column].data;
            delete d.start;
            delete d.length;
            delete d.columns;
            delete d.draw;
          },
        },
        columns: [
          {
            // grabing data and pre proccessing it using datatable render func
            data: "id",
            render: function (data, type, row, meta) {
              return (
                '<div style="min-width: 60px;"> <span class="badge">' + "ID " + data +
                '</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Products.editProduct(' +
                data +
                ')"><i class="fa fa-edit"></i></a> </div>' +
                '<div style="min-width: 60px;"><a class="pull-left" style="font-size: 15px; cursor: pointer;" onclick="Products.editProductStock(' +
                data +
                ')"><i class="fa fa-cubes"></i> Stock </a> </div>' 

              );
            },
          },

          {
            // grabing data and pre proccessing it using datatable render func
            data: "image_link",
            render: function (data, type, row, meta) {
              return `<img src="${data}" width="50px" height="50px">`;
            },
          },
          { data: "name" },
          { data: "unit_price" },
          { data: "gender_category" },
          { data: "subcategory_id" },
          { data: "created_at" },
          
        ],
      });
    }

}