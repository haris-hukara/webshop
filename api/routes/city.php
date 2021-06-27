<?php
/**
 * @OA\Get(path="/admin/city", tags={"city"},security={{"ApiKeyAuth":{}}},
 *                    @OA\Parameter( type="integer", in="query",name="offset", default=0, description= "Offset for paggination"),           
*                     @OA\Parameter( type="integer", in="query",name="limit", default=10, description= "Limit for paggination"),
*                     @OA\Parameter( type="integer", in="query",name="search", default="Sarajevo", description= "Case insensitive search for cities"),
*                     @OA\Parameter( type="string", in="query",name="order", default="-id", description= "Sorting elements by column_name <br><br>  -column_name for ascending order <br>+column_name for descending order"),
 *     @OA\Response(response="200", description="List of all cities from database with paggination")
 * )
 */
Flight::route('GET /admin/city', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    
    $order = Flight::query('order', "-id");    

    flight::json(Flight::cityService()->get_cities($search, $offset, $limit, $order));
});



/**
*  @OA\Post(path="/admin/city",tags={"city"},security={{"ApiKeyAuth":{}}},
*  @OA\RequestBody(description ="Body for order", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="city_name", 
*                                      type="string",
*                                      example="tuzla",
*                                      description="Input for adding city name. First letter of each word in city name is converted to uppercase, other letters are lowercase <br> example: cITy -> City"),           
*                     @OA\Property(property="country_name", 
*                                      type="string",
*                                      example="Bosnia and Herzegovina",
*                                      description="Input for country name to which city is added. Used for finding country_id based on user input, case insensitive"),   
*
*            ) 
*        )
*   ),
*    @OA\Response(response="200", description="Adding city to a country if that country exists in database")
* )     
*/ 
Flight::route('POST /admin/city', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::cityService()->add_city($data));
});
?>