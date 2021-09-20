class UserProfile{

  static init(){
    UserProfile.loadProfile(parse_jwt(window.localStorage.getItem("token")).id);
    $("#user-profile-form").validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        UserProfile.updateDetails(jsonize_form($(form)));
      },
    });
  
    $("#user-email-form").validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        UserProfile.updateEmail(jsonize_form($(form)));
      },
    });
  
    $("#user-password-form").validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        UserProfile.updatePassword(jsonize_form($(form)));
      },
    });
    
 //   AUtils.role_based_elements();
 //   EmailTemplate.get_all();
 //   EmailTemplate.chart();
  }

  static loadProfile(account_id){
   RestClient.get("api/user/details/"+account_id, function(data){
        $("#up_fname").val( data.name);
        $("#up_lname").val(data.surname);
        $("#up_email_address").val( data.email);
        $("#up_phone").val( data.phone_number);
        $("#up_city").val( data.city);
        $("#up_postal_zip").val( data.zip_code);
        $("#up_address").val( data.address);
        $("#ac_password").val("");
    });
    UserProfile.loadAccountInfo(account_id);
  }

  static loadAccountInfo(account_id){
      RestClient.get("api/user/account/" + account_id, function(data){
          $("#ac_email").val(data.email);
      });
  }

  static updateDetails(details){
    var account_id = parseInt(parse_jwt(window.localStorage.getItem("token")).id);
    RestClient.put("api/user/details/" + account_id, details, function(data){
      $('[id^=up]').prop('disabled', true);
      UserProfile.loadProfile(account_id);
      toastr.success("Your profile info has been updated");
      });
  }



  static updatePassword(details){
    var account_id = parse_jwt(window.localStorage.getItem("token")).id
    RestClient.get("api/user/password/account/"+account_id+"?password="+details.old_password, function(data){
      if(data == true){
        delete details['old_password'];
        RestClient.put("api/account/"+account_id, details, function(data){
          $('[id^=cp_]').prop('disabled', true);
          $('[id^=cp_]').val("");
          toastr.success("Your password has been updated");
        })
      }else{
        toastr.error("Wrong password");
      }
    });
  }

  static updateEmail(details){
    var account_id = parse_jwt(window.localStorage.getItem("token")).id
    RestClient.get("api/user/password/account/"+account_id+"?password="+details.password, function(data){
      if(data == true){
        delete details['password'];
        RestClient.put("api/account/"+account_id, details, function(data){
          $('[id^=ac_]').prop('disabled', true);
          $('[id=ac_password]').val("");
          toastr.success("Your email address for login has been updated");
        })
      }else{
        toastr.error("Wrong password");
      }
    });
  }


  static checkPassword(details){
    var account_id = parse_jwt(window.localStorage.getItem("token")).id
    RestClient.get("api/user/password/account/"+account_id+"?password="+details.password, function(data){
      if(data == true){
        UserProfile.updatePassword(details,account_id)
      }else{
        toastr.error("Wrong password");
      }
    })
  }

  static setDetailsEditable(){
    $('[id^=up]').removeAttr("disabled");
    }
  static setEmailEditable(){
    $('[id^=ac_]').removeAttr("disabled");
  }
  
  static setPasswordEditable(){
    $('[id^=cp_]').removeAttr("disabled");
  }
  
}
