<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CountryDao.class.php";



class CountryService extends BaseService{
 
  
   public function __construct(){
     $this->dao = new CountryDao();   
    }

    public function get_countries($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_countries($search, $offset, $limit, $order));
            }else{
              return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_country($countryDetails){
        if(!isset($countryDetails['name'])) throw new Exception("Country name is missing");

        $cuntryName = ucwords(strtolower($countryDetails['name']));       
        
      try {
        $country = parent::add([
        "name" => $cuntryName ]); 
        
      } catch (\Exception $e) {
        if(str_contains($e->getMessage(), 'country.name_UNIQUE')){
          throw new Exception("Country with same name already exist", 400, $e);
        }else{
          throw $e;    
        }  
        
      }
      return $country;
        
    }
    
    public function update_country($id, $data){
      
      if(!isset($data['name'])) throw new Exception("Name is missing");
      
      $country = parent::update($id,
                            [ "name" => ucwords(strtolower($data['name'])) ]
      ); 
      
        return $country;
    }

}
?>




  