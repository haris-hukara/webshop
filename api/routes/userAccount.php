<?php
/**
 * @OA\Info(title="OnlineShop API", version="0.1")
 *    @OA\OpenApi(
 *      @OA\Server(url="http://localhost/webshop/api/", description="Developer environment")
 * ) 
 *  @OA\SecurityScheme(
 *      securityScheme="ApiKeyAuth",
 *      name="Authentication",
 *      in="header",
 *      type="apiKey",
 * )    
 */

/**
 * @OA\Get(path="/account", tags={"account"},
 *     @OA\Response(response="200", description="List of all accounts from database")
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
 * @OA\Get(path="/account/{id}",tags={"account"}, security={{"ApiKeyAuth":{}}}, 
 *     @OA\Parameter(
 *         name="Authentication",
 *         in="header",
 *         required=true,
 *         description="JWT {access-token}",
 *          default ="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJybCI6IlVTRVIifQ.2JLdTXnlSOYE2PsbQykMKFtT7C1B6F728BWZ2XThv-I",
 *      @OA\SecurityScheme(
 *      securityScheme="ApiKeyAuth"
 * ),
 *      ), 
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example = 1, description="Search for account based on account_id"),
 *     @OA\Response(response="200", description="List of accounts from database based on account_id")
 *)
 */
Flight::route('GET /account/@id', function($id){
    $headers = getallheaders();
    $JWTtoken = @$headers['Authentication'];

    try {
        $decoded = (array)\Firebase\JWT\JWT::decode($JWTtoken, "JWT SECRET",['HS256']);
        if($decoded['id'] == $id){
        Flight::json(Flight::userAccountService()->get_by_id($id));
    }else{
        Flight::json(["message" => "This account is not yours" ]);
    }
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
    }
   
});


/*
Flight::route('POST /account', function(){
    $data = Flight::request()->data->getdata();
    flight::json(Flight::userAccountService()->add($data));
}); */

/**
* @OA\Put(path="/account/{id}",tags={"account"},
* @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example = "1", description="Update account by account_id"),
**@OA\RequestBody(description ="Basic account info that is going to be updated", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="email", type="string",example="example@email.ba",description="123"),           
*                     @OA\Property(property="password", type="string",example="password",description="123"),           
*            ) 
*        )
*   ), 
* @OA\Response(response="200", description="Update account message")
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
*  @OA\Response(response="200", description="Account registration message")
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
*  @OA\Response(response="200", description="Message that user logged in")
* )     
*/ 
Flight::route('POST /account/login', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::userAccountService()->login($data));
});

/**
*@OA\Post(path="/account/forgot",tags={"account"}, description="Send recovery URL to user email",
*@OA\RequestBody(description ="Basic user login info", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="email",required = true, type="string",example="haris.hukara@stu.ibu.edu.ba",description="User's email")
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Message from recovery link has been sent")
* )     
*/ 
Flight::route('POST /account/forgot', function(){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->forgot($data);
    Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
*@OA\Post(path="/account/reset",tags={"account"}, description="Reset user password using recovery token",
*@OA\RequestBody(description ="Basic user login info", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="token",required = true, type="string",example="token123",description="Recovery token"),
*                     @OA\Property(property="password",required = true, type="string",example="password123",description="New password")
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Message that has been sent by recovery link")
* )     
*/ 
Flight::route('POST /account/reset', function(){
    $data = Flight::request()->data->getdata();
    Flight::userAccountService()->reset($data);
    Flight::json(["message" => "Your password has been changed"]);
});
?>