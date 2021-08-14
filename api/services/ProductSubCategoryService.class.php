<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ProductSubCategoryDao.class.php";



class ProductSubCategoryService extends BaseService{
 
  
   public function __construct(){
     $this->dao = new ProductSubCategoryDao();   
    }

    public function get_product_subcategories($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_product_subcategories($search, $offset, $limit, $order));
            }else{
              return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_product_subcategory($data){
        if(!isset($data['name'])) throw new Exception("Product Subcategory name is missing");

        $product_subcategory_name = ucwords(strtolower($data['name']));       
        
      try {
        $product_subcategory = parent::add([
        "name" => $product_subcategory_name ,
        "category_id" => $data['category_id'] ]); 
        
      } catch (\Exception $e) {
        if(str_contains($e->getMessage(), 'product_subcategory.name_UNIQUE')){
          throw new Exception("Product Subcategory with same name already exist", 400, $e);
        }else{
          throw $e;    
        }  
        
      }
      return $product_subcategory;
        
    }
    
    public function update_product_subcategory($id, $data){
      
      if(!isset($data['name'])) throw new Exception("Name is missing");
      
      $product_subcategory = parent::update($id,
                            [ "name" => ucwords(strtolower($data['name'])) ]
      ); 
        return $product_subcategory;
    }

}
?>




  