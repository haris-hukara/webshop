<?php
/**
 * @OA\Get(path="/admin/country", tags={"country","admin"},security={{"ApiKeyAuth":{}}},
 *                    @OA\Parameter( type="integer", in="query",name="offset", default=0, description= "Offset for paggination"),           
*                     @OA\Parameter( type="integer", in="query",name="limit", default=10, description= "Limit for paggination"),
*                     @OA\Parameter( type="integer", in="query",name="search", default="Sarajevo", description= "Case insensitive search for cities"),
*                     @OA\Parameter( type="string", in="query",name="order", default="-id", description= "Sorting elements by column_name <br><br>  -column_name for ascending order <br>+column_name for descending order"),
 *     @OA\Response(response="200", description="List of all cities from database with paggination")
 * )
 */
Flight::route('GET /admin/country', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");    

    flight::json(Flight::countryService()->get_countries($search, $offset, $limit, $order));
});


/**
 * @OA\Get(path="/admin/country/{id}", tags={"country","admin"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Country id"),
 *     @OA\Response(response="200", description="Country info")
 * )
 */
Flight::route('GET /admin/country/@id', function($id){  
    flight::json(Flight::countryService()->get_by_id($id));
});

 /**
* @OA\Put(path="/admin/country/{id}",tags={"country","admin"},security={{"ApiKeyAuth":{}}},
* @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example = "1", description="Update country by id"),
**@OA\RequestBody(description ="Basic account info that is going to be updated", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="name", type="string",example="Name of country",description="123"),           
*            ) 
*        )
*   ), 
* @OA\Response(response="200", description="Update account message")
* )     
*/ 
Flight::route('PUT /admin/country/@id', function($id){  
    $data = Flight::request()->data->getdata();
    flight::json(Flight::countryService()->update_country($id, $data));
});



/**
*  @OA\Post(path="/admin/country",tags={"country","admin"},security={{"ApiKeyAuth":{}}},
*  @OA\RequestBody(description ="Body for order", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="name", 
*                                      type="string",
*                                      example="tuzla",
*                                      description="Input for adding city name. First letter of each word in city name is converted to uppercase, other letters are lowercase <br> example: cITy -> City"), 
*
*            ) 
*        )
*   ),
*    @OA\Response(response="200", description="Adding city to a country if that country exists in database")
* )     
*/ 
Flight::route('POST /admin/country', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::countryService()->add_country($data));
});
?>