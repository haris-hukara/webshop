<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CityDao.class.php";
require_once dirname(__FILE__)."/../dao/CountryDao.class.php";


class CityService extends BaseService{
    
    private $countryDao;
  
   public function __construct(){
     $this->dao = new CityDao();   
     $this->countryDao = new CountryDao();   
    }

    public function get_cities($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_cities($search, $offset, $limit, $order));
            }else{
          return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_city($cityDetails){
        if(!isset($cityDetails['city_name'])) throw new Exception("Name is missing");
        if(!isset($cityDetails['country_name'])) throw new Exception("Country is missing");

        $cityName = ucwords($cityDetails['city_name']);
        $countryName = $cityDetails['country_name'];
        $countryID = $this->countryDao->get_country_id($countryName);
        
        if( $countryID != null ){    
                $city = parent::add([
                "name" => $cityName,
                "country_id" => $countryID]); 
        };
     
    }


}
?>




  