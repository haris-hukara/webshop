<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ProductCategoryDao.class.php";



class ProductCategoryService extends BaseService{
 
  
   public function __construct(){
     $this->dao = new ProductCategoryDao();   
    }

    public function get_product_categories_count(){
              return ($this->dao-> get_category_count());
 }
    public function get_product_categories($search, $offset, $limit, $order){
            if ($search){
              return ($this->dao->get_product_categories($search, $offset, $limit, $order));
            }else{
              return ($this->dao->get_all($offset,$limit, $order));
      }
 }

    public function add_product_category($data){
        if(!isset($data['name'])) throw new Exception("Product Category name is missing");

        $product_category_name = ucwords(strtolower($data['name']));       
        
      try {
        $product_category = parent::add([
        "name" => $product_category_name ]); 
        
      } catch (\Exception $e) {
        if(str_contains($e->getMessage(), 'product_category.name_UNIQUE')){
          throw new Exception("Product Category with same name already exist", 400, $e);
        }else{
          throw $e;    
        }  
        
      }
      return $product_category;
        
    }
    
    public function update_product_category($id, $data){
      
      if(!isset($data['name'])) throw new Exception("Name is missing");
      
      $product_category = parent::update($id,
                            [ "name" => ucwords(strtolower($data['name'])) ]
      ); 
        return $product_category;
    }

}
?>




  