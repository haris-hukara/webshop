<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductStockDao extends BaseDao{

    public function __construct(){
        parent::__construct("product_stock");
    }



?>