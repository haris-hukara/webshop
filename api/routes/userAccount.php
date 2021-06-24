<?php
/**
 * @OA\Info(title="OnlineShop API", version="0.1")
 *    @OA\OpenApi(
 *      @OA\Server(url="http://localhost/webshop/api/", description="Developer environment")
 * )
 */

/**
 * @OA\Get(path="/account", tags={"account"},
 *     @OA\Response(response="200", description="List all accounts from database")
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
 * @OA\Get(path="/account/{id}",tags={"account"},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example = 50, description="Search for account based on account_id"),
 *     @OA\Response(response="200", description="List accounts from database by account_id")
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

/**
* @OA\Put(path="/account/{id}",tags={"account"},
* @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example = "28", description="Update account by account_id"),
**@OA\RequestBody(description ="Basic account info that is going to be updated", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="email", type="string",example="emai213l@email.ba",description="123"),           
*                     @OA\Property(property="password", type="string",example="password",description="123"),           
*            ) 
*        )
*   ), 
* @OA\Response(response="200", description="Update account based on account id")
* )     
*/ 
Flight::route('PUT /account/@id', function($id){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->update($id, $data);
});


/* user account registration route*/
/**
*@OA\Post(path="/account/register",tags={"account"},
*@OA\RequestBody(description ="Body for user registrations", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="name",required = true, type="string",example="name",description="Name"),           
*                     @OA\Property(property="surname",required = true, type="string",example="surname",description="Surname"),           
*                     @OA\Property(property="email",required = true, type="string",example="haris.hukara@stu.ibu.edu.ba",description="User's email"),           
*                     @OA\Property(property="password",required = true, type="string",example="password",description="User password"),           
*                     @OA\Property(property="phone_number",required = true, type="string",example="000 000 000",description="Phone number"), 
*                     @OA\Property(property="city",required = true, type="string",example="city",description="City name"),           
*                     @OA\Property(property="zip_code",required = true, type="string",example="71000",description="5 digit zip code"),
*                     @OA\Property(property="address",required = true, type="string",example="address 13",description="User address")           
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/ 
Flight::route('POST /account/register', function(){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->register($data);
    Flight::json(["message"=>"Confirmation email has been sent. Pleas confirm your account "]);
});

/* user account confirm registration route*/
Flight::route('GET /account/confirm/@token', function($token){
    Flight::userAccountService()->confirm($token);
    Flight::json(["message" => "Your account had been activated"]);
});

/**
*@OA\Post(path="/account/login",tags={"account"},
*@OA\RequestBody(description ="Basic user login info", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="email",required = true, type="string",example="haris.hukara@stu.ibu.edu.ba",description="User's email"),           
*                     @OA\Property(property="password",required = true, type="string",example="password",description="User password")           
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/ 
Flight::route('POST /account/login', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::userAccountService()->login($data));
});
?>