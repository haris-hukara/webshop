<?php 

Flight::route('GET /userDetails/@id', function($id){
    Flight::json(Flight::userDetailsService()->get_by_id($id));
});

Flight::route('POST /userDetails', function(){
    $data = Flight::request()->data->getdata();
    flight::json(Flight::userDetailsService()->add($data));
});

?>