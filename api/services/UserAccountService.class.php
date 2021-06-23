<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserAccountDao.class.php";
require_once dirname(__FILE__)."/../dao/UserDetailsDao.class.php";

require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class UserAccountService extends BaseService{
    
  private $userDetailsDao;
  private $smtpClient;
  
   public function __construct(){
     $this->dao = new UserAccountDao();   
     $this->userDetailsDao = new UserDetailsDao();
     $this->smtpClient = new SMTPClient();
    }

/* 
   $this->dao->beginTransaction()
          $this->dao->commit()
          $this->dao->rollBack()*/
    public function register($userAccount){
      if(!isset($userAccount['email'])) throw new Exception("Email is missing");
      $userAccount['created_at'] = date(Config::DATE_FORMAT);
     try {
        $details = $this->userDetailsDao->add([
        "name" => $userAccount['name'],
        "surname" => $userAccount['surname'],
        "email" => $userAccount['email'],
        "phone_number" => $userAccount['phone_number'],
        "city" => $userAccount['city'],
        "zip_code" => $userAccount['zip_code'],
        "address" => $userAccount['address'],
        "created_at" => $userAccount['created_at']
      ]);
      
      $userAccount = $this->dao->add([
        "email" => $details['email'],
        "password" => $userAccount['password'],
        "user_details_id" => $details['id'],
        "status" => "PENDING",
        "role" => "USER",
        "created_at" => $userAccount['created_at'],
        "token" => md5(random_bytes(16))
      ]); 

       } catch (\Exception $e){
       if(str_contains($e->getMessage(), 'user_account.email_UNIQUE')){
         throw new Exception("Account with same email exsists in the database", 400, $e);
        }else{
          throw $e;    
        } 
      }
      $this->smtpClient->send_registration_token($userAccount);
      return $userAccount;
  }
    
    public function confirm($token){
      $userAccount = $this->dao->get_user_by_token($token);

      if(!isset($userAccount['id'])) throw new Exception("Invalid token");
    
    $this->dao->update($userAccount['id'], ["status" => "ACTIVE"]);
    
  }
    // TODO: send email to user
  
   public function get_user_account($search, $offset, $limit, $order){
  
              if ($search){
                return ($this->dao->get_user_account($search, $offset, $limit, $order));
              }else{
            return ($this->dao->get_all($offset,$limit, $order));
        }
   }

  }
?>




  