<?php
require dirname(__FILE__).'/../vendor/autoload.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/hello2', function(){
    echo 'hello world2!';
});

Flight::start();
?>