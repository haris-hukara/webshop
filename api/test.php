<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserAccountDao.class.php";

$user_dao = new UserDao();

// $user = $user_dao->get_user_by_email("haris@email.ba");

$user1 = [
    "email" => "haris122@mail.com",
    "password" => "1234444424",
    "customer_details_id" => 1
];

// $user_dao->add_user($user);
$user = $user_dao->add_user($user1);


?>