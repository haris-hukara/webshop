function jsonize_form(selector){
    var data = $(selector).serializeArray();
    var form_data = {};
    for (let i = 0; i < data.length; i++) {
      form_data[data[i].name] = data[i].value;
    }
    return form_data;
}

/* decoding jwt token */
function parse_jwt(token){
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c){
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}



function setCartCount(){
    if(getCart() == false || JSON.parse(getCart()).length == 0 ){
        document.getElementById("count").setAttribute("hidden","true");
    }
    else{
      document.getElementById("count").innerHTML = JSON.parse(getCart()).length
      document.getElementById("count").removeAttribute("hidden");
    }
  }

  function getCart(){
    if (localStorage.getItem('products') == null){
      return false;
    }
    return localStorage.getItem('products'); 
  }

  function setCartEmpty(){
    localStorage.setItem('products','[]');
  }