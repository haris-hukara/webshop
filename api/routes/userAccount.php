<?php


Flight::route('GET /account', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    
    flight::json(Flight::userAccountService()->get_user_account($search, $offset, $limit));
});


Flight::route('GET /account/@id', function($id){
    Flight::json(Flight::userAccountService()->get_by_id($id));
});


Flight::route('POST /account', function(){
    $data = Flight::request()->data->getdata();
    flight::json(Flight::userAccountService()->add($data));
});


Flight::route('PUT /account/@id', function($id){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->update($id, $data);
});

?>