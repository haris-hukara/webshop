<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require dirname(__FILE__).'/dao/UserAccountDao.class.php';
require dirname(__FILE__).'/../vendor/autoload.php';


Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/account', function(){
    $dao = new UserAccountDao();
    $accounts = $dao->get_all(0,10);
    Flight::json($accounts);
    
});

Flight::start();
?>