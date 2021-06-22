<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class CountryDao extends BaseDao{

    public function __construct(){
        parent::__construct("country");
    }
   
    public function get_country_id($country){
        $country = $this->query_unique("SELECT *
                                     FROM country
                                     WHERE LOWER(name) = :name", ["name" => strtolower($country)]);
        return $country['id'];
    }

 

}
?>