<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class CountryDao extends BaseDao{

    public function __construct(){
        parent::__construct("country");
    }
   
    public function get_country_id_by_name($country){
        $country = $this->query_unique("SELECT *
                                        FROM country
                                        WHERE LOWER(name) = :name", ["name" => strtolower($country)]);
        return $country;
    }
    
    public function get_country_name_by_id($id){
        $country = $this->query_unique("SELECT *
                                        FROM country
                                        WHERE id = :id", ["id" => $id]);
        return $country;
    }

    public function get_countries($search, $offset, $limit, $order = "-id"){
        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };
        
        return $this->query( "SELECT * 
                              FROM country
                              WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                              ORDER BY ${order} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", 
                             ["name" => strtolower($search)]);
    }

}
?>