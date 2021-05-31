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
        $sql = "INSERT INTO user_account ( email, password, customer_details_id ) VALUES 
                                        ( :email, :password, :customer_details_id )";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
    }
    

    public function update_user($id, $user){
        
        $query = "UPDATE user_account SET ";

        foreach($user as $key => $value){
            $query .= $key ." = :". $key. ", ";
        }
        
        $query = substr($query, 0, -2);
        $query .= " WHERE account_id = :id";

        $stmt = $this->connection->prepare($query);
        $user['id'] = $id;
        $stmt->execute($user);

    }


}
?>