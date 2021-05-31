<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserAccountDao.class.php";
require_once dirname(__FILE__)."/dao/CustomerDetailsDao.class.php";

$dao = new CustomerDetailsDao();

// $user = $user_dao->get_user_by_email("haris@email.ba");

$details = [
    "name" => "Ime",
    "surname" => "prezime",
    "email" => "mail@mail.com",
    "phone_number" => "123 123 123",
    "city_id" => 1,
    "zip_code" => "71000",
    "address" => "adresa stanovanja 1"
];

// $user_dao->add_user($user);
$user = $dao->get_customer_details(2);

print_r($user);


?>