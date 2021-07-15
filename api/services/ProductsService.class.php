<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ProductsDao.class.php";



class ProductsService extends BaseService{

    
   public function __construct(){ 
     $this->dao = new ProductsDao();   
    }

    public function get_product_stock($id, $size = NULL){
        return $this->dao->get_product_stock($id, $size);
    }

  }
?>




  