 <?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class UserAccountDao extends BaseDao{

    public function __construct(){
        parent::__construct("user_account");
    }
    
    public function get_user_account($search, $offset, $limit){
        return $this->query("SELECT * 
                             FROM user_account
                             WHERE LOWER(email) LIKE CONCAT('%', :email, '%')
                             LIMIT ${limit} OFFSET ${offset}", ["email" => strtolower($search)]);
    }

    public function get_user_by_email($email){
     return $this->query_unique("SELECT * 
                                 FROM user_account
                                 WHERE email = :email" , ["email" => $email]);
         
    }
    
    public function update_user_by_email($email, $entity){
        $this->update("user_account", $email, $entity, "email");

    }


}
?>