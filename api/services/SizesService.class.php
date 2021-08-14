<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/SizesDao.class.php";



class SizesService extends BaseService{
 
  
   public function __construct(){
     $this->dao = new SizesDao();   
    }

    public function get_sizes($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_sizes($search, $offset, $limit, $order));
            }else{
              return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_sizes($data){
        if(!isset($data['name'])) throw new Exception("Sizes name is missing");

        $sizes_name = ucwords(strtolower($data['name']));       
        
      try {
        $sizes = parent::add([
        "name" => $sizes_name ]); 
        
      } catch (\Exception $e) {
        if(str_contains($e->getMessage(), 'sizes.name_UNIQUE')){
          throw new Exception("Size with same name already exist", 400, $e);
        }else{
          throw $e;    
        }  
        
      }
      return $sizes;
        
    }
    
    public function update_sizes($id, $data){
      
      if(!isset($data['name'])) throw new Exception("Name is missing");
      
      $sizes = parent::update($id,
                            [ "name" => ucwords(strtolower($data['name'])) ]
      ); 
        return $sizes;
    }

}
?>




  