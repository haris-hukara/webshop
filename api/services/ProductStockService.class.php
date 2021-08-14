<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ProductStockDao.class.php";

class ProductStockService extends BaseService{

    
   public function __construct(){ 
     $this->dao = new ProductStockDao();   
    }

    public function get_product_stock($id, $size = NULL){
        return $this->dao->get_product_stock_by_size_name($id, $size);
    }

    public function add_product_stock($details){
        if(!isset($details['product_id'])) throw new Exception("Product id is missing");
        if(!isset($details['size_id'])) throw new Exception("Product size id is missing");
        if(!isset($details['quantity_avaliable'])) throw new Exception("Quantity is missing");
  
        try {
            $product_stock = parent::add([
                "product_id" => $details['product_id'],
                "size_id" => $details['size_id'],
                "quantity_avaliable" => $details['quantity_avaliable']
              ]); 
          
              return $product_stock;
          
            } catch (\Exception $e) {
              if(str_contains($e->getMessage(), 'product_stock.PRIMARY')){
                  throw new Exception("Stock for this product and this size already exist", 400, $e);
              } else { 
                throw $e;
                }
          }
    }
  
    public function update_product_stock($details){
        if(!isset($details['product_id'])) throw new Exception("Product id is missing");
        if(!isset($details['size_id'])) throw new Exception("Product size id is missing");
        if(!isset($details['quantity_avaliable'])) throw new Exception("Quantity is missing");

        $product_stock = $this->dao->update_product_stock( $details['product_id'],
                                                           $details['size_id'],
                                                           $details['quantity_avaliable']);

        return $product_stock;
      }

}
?>