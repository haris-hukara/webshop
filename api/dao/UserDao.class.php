 <?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

    public function get_user_by_email($email){
     return $this->query_unique("SELECT * 
                                 FROM user_account
                                 WHERE email = :email" , ["email" => $email]);
         
    }
    
    public function get_user_by_id($id){
     return $this->query_unique("SELECT * 
                                 FROM user_account
                                 WHERE id = :id" , ["id" => $id]);    
    }
    

    public function add_user($user){
      return $this->insert("user_account", $user);
    }
    

    public function update_user($id, $entity){
        $this->update("user_account", $id, $entity);

    }

    public function update_user_by_email($email, $entity){
        $this->update("user_account", $email, $entity, "email");

    }


}
?>