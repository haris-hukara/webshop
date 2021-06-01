<?php

Flight::route('GET /account', function(){
    Flight::json(Flight::userAccountDao()->get_all(0,10));
});

Flight::route('GET /account/@id', function($id){
    Flight::json(Flight::userAccountDao()->get_by_id($id));
});

Flight::route('POST /account', function(){
    $data = Flight::request()->data->getdata();
    flight::json(Flight::userAccountDao()->add($data));
});

Flight::route('PUT /account/@id', function($id){
    $data = Flight::request()->data->getdata();
    Flight::userAccountDao()->update($id, $data);
    flight::json(Flight::userAccountDao()->get_by_id($id));
});

?>