<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require dirname(__FILE__).'/dao/UserAccountDao.class.php';
require dirname(__FILE__).'/../vendor/autoload.php';

Flight::register('userAccountDao', 'UserAccountDao');

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('GET /account', function(){
    Flight::json(Flight::userAccountDao()->get_all(0,10));
});

Flight::route('GET /account/@id', function($id){
    Flight::json(Flight::userAccountDao()->get_by_id($id));
});

Flight::route('POST /account', function(){
    $request = Flight::request()->data->getdata();
    flight::json(Flight::userAccountDao()->add($request));
});

Flight::route('PUT /account/@id', function($id){
    $request = Flight::request()->data->getdata();
    Flight::userAccountDao()->update($id, $request);
    flight::json(Flight::userAccountDao()->get_by_id($id));
});

Flight::start();
?>