<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductCategoryDao extends BaseDao{

    public function __construct(){
        parent::__construct("product_category");
    }



?>