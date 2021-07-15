<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CityDao.class.php";



class CityService extends BaseService{
 
  
   public function __construct(){
     $this->dao = new CityDao();   
    }

    public function get_cities($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_cities($search, $offset, $limit, $order));
            }else{
          return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_city($cityDetails){
        if(!isset($cityDetails['name'])) throw new Exception("City name is missing");
        if(!isset($cityDetails['country_id'])) throw new Exception("Country ID is missing");

        $cityName = ucwords(strtolower($cityDetails['name']));       
        
      try {
        $city = parent::add([
        "name" => $cityName,
        "country_id" => $cityDetails['country_id']]); 
        
      } catch (\Exception $e) {
        if(str_contains($e->getMessage(), 'city.name_UNIQUE')){
          throw new Exception("City with same name already exist", 400, $e);
        }else{
          throw $e;    
        }  
        
      }
      return $city;
        
    }
    
    public function update_city($id, $data){
      
      if(!isset($data['name'])) throw new Exception("Name is missing");
      if(!isset($data['country_id'])) throw new Exception("Country id is missing");
      
      $city = parent::update($id,
      ["name" => ucwords(strtolower($data['name'])),
       "country_id" => $data['country_id']]
      ); 
      
        return $city;
    }

}
?>




  