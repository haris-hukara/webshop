<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/dao/CountryDao.class.php';
require_once dirname(__FILE__).'/dao/OrderDetailsDao.class.php';


   // $dao = new CountryDao();
   // $result = $dao->get_country_name_by_id(1);
  
  
   $dao = new OrderDetailsDao();
    $result = $dao->get_order_details_by_id(1);
        print_r($result);

?>
 