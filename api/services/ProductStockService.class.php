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


}
?>




  