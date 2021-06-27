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
        return $country['id'];
    }
    
    public function get_country_name_by_id($id){
        $country = $this->query_unique("SELECT *
                                     FROM country
                                     WHERE id = :id", ["id" => $id]);
        return $country['name'];
    }

 

}
?>