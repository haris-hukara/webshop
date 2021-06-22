<?php
/**
 * @OA\Get(path="/city", tags={"city"},
 *     @OA\Response(response="200", description="List all cities from database, offset, limit, and search are supported")
 * )
 */
Flight::route('GET /city', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    
    $order = Flight::query('order', "-id");    

    flight::json(Flight::cityService()->get_cities($search, $offset, $limit, $order));
});



/**
*  @OA\Post(path="/city",tags={"city"},
*  @OA\RequestBody(description ="Body for user registrations", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="city_name", type="string",example="tuzla",description="getting city name and converting it so that first letter of each word is upper cased"),           
*                     @OA\Property(property="country_name", type="string",example="Bosnia and Herzegovina",description="getting country name from user so that we can add id for city country_id field")     
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/ 
Flight::route('POST /city', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::cityService()->add_city($data));
});
?>