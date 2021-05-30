<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$user_dao = new UserDao();

// $user = $user_dao->get_user_by_email("haris@email.ba");

$user = [
    "email" => "Samir@mail.com",
    "password" => "pass",
    "customer_details_id" => 1
];

$user_dao->add_user($user);


?>