<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserAccountDao.class.php";
require_once dirname(__FILE__)."/dao/CustomerDetailsDao.class.php";

$dao = new CustomerDetailsDao();

// $user = $user_dao->get_user_by_email("haris@email.ba");

$details = [
    "name" => "Przi",
    "surname" => "Przovski",
    "email" => "mai111l@mail.com",
    "phone_number" => "12223 123 123",
    "city_id" => 1,
    "zip_code" => "71000",
    "address" => "adresa stanov 123"
];

// $user_dao->add_user($user);
$user = $dao->add($details);
print_r ($user);



?>