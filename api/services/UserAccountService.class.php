<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserAccountDao.class.php";
require_once dirname(__FILE__)."/../dao/UserDetailsDao.class.php";

class UserAccountService extends BaseService{
    
  private $userDetailsDao;
    
    public function __construct(){
     $this->dao = new UserAccountDao();   
     $this->userDetailsDao = new UserDetailsDao();   
    }


    public function register($userAccount){
      if(!isset($userAccount['email'])) throw new Exception("Email is missing");

      // open transaction here
      $details = $this->userDetailsDao->add([
        "name" => $userAccount['name'],
        "surname" => $userAccount['surname'],
        "email" => $userAccount['email'],
        "phone_number" => $userAccount['phone_number'],
        "city" => $userAccount['city'],
        "zip_code" => $userAccount['zip_code'],
        "address" => $userAccount['address'],
        "created_at" => date(Config::DATE_FORMAT)
      ]);
     

      parent::add([
        "email" => $details['email'],
        "password" => $userAccount['password'],
        "user_details_id" => $details['id'],
        "status" => "PENDING",
        "role" => "USER",
        "created_at" => date(Config::DATE_FORMAT),
        "token" => md5(random_bytes(16))
      ]);
    }
    // commit transaction here
    

    public function get_user_account($search, $offset, $limit){

            if ($search){
              return ($this->dao->get_user_account($search, $offset, $limit));
            }else{
              return ($this->dao->get_all($offset,$limit));
            }
        }
    
    public function add($userAccount){
        if(!isset($userAccount['email'])) throw new Exception("Email is missing");
    
    return parent::add($userAccount);
    }

}
?>