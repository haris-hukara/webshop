<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/dao/CityDao.class.php';


    $dao = new CityDao();

    $result = $dao->get_country_name("Sarajevo");
    
    print_r($result);

?>
 