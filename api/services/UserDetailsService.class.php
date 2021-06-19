<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDetailsDao.class.php";
require_once dirname(__FILE__)."/../dao/UserAccountDao.class.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class UserDetailsService extends BaseService{

    public function __construct(){
     $this->dao = new UserDetailsDao();   
    }

    /* add override */
    public function add($userDetails){
      if(!isset($userDetails['name'])) throw new Exception("Name is missing");
      if(!isset($userDetails['surname'])) throw new Exception("Surname is missing");
      if(!isset($userDetails['email'])) throw new Exception("Email is missing");
      if(!isset($userDetails['phone_number'])) throw new Exception("Phone is missing");
      if(!isset($userDetails['city'])) throw new Exception("City is missing");
      if(!isset($userDetails['zip_code'])) throw new Exception("Zip Code is missing");
      if(!isset($userDetails['address'])) throw new Exception("Address is missing");
      

    return parent::add($userDetails);
  }



}
?>