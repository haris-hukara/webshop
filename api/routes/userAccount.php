<?php
/**
 * @OA\Info(title="OnlineShop API", version="0.1")
 *    @OA\OpenApi(
 *      @OA\Server(url="http://localhost/webshop/api/", description="Developer environment")
 * )
 */

/**
 * @OA\Get(path="/account",
 *     @OA\Response(response="200", description="List accounts from database")
 * )
 */

Flight::route('GET /account', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    
    $order = Flight::query('order', "-id");    

    flight::json(Flight::userAccountService()->get_user_account($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/account/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"),in="path", allowReserved=true, name="id", example="1"),
 *     @OA\Response(response="200", description="List accounts from database")
 *)
 */
Flight::route('GET /account/@id', function($id){
    Flight::json(Flight::userAccountService()->get_by_id($id));
});


/*
Flight::route('POST /account', function(){
    $data = Flight::request()->data->getdata();
    flight::json(Flight::userAccountService()->add($data));
}); */


Flight::route('PUT /account/@id', function($id){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->update($id, $data);
});

/* user account registration route*/
Flight::route('POST /account/register', function(){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->register($data);
});

/* user account confirm registration route*/
Flight::route('GET /account/confirm/@token', function($token){
    Flight::userAccountService()->confirm($token);
    Flight::json(["message" => "Account activated"]);
});



?>