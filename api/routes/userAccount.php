<?php


Flight::route('GET /account', function(){
    $request = Flight::request();
    
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    
    $search = Flight::query('search');
    
    if ($search){
      Flight::json(Flight::userAccountDao()->get_user_account($search, $offset, $limit));
    }else{
      Flight::json(Flisght::userAccountDao()->get_all($offset,$limit));
    }

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