<?php
/**
 * @OA\Get(path="/admin/orders", tags={"order","admin"},security={{"ApiKeyAuth":{}}},
  *    @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Address search string for orders. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List accounts from database")
 * )
 */
Flight::route('GET /admin/orders', function(){  
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");    

    flight::json(Flight::orderService()->get_orders($search, $offset, $limit, $order));
});

/**
*  @OA\Post(path="/order",tags={"order"},
*  @OA\RequestBody(description ="Body for order", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="user_details_id", 
*                                      type="int",
*                                      example="38",
*                                      description="ID of user details"),           
*                     @OA\Property(property="shipping_address", 
*                                      type="string",
*                                      example="Adresa 123",
*                                      description="Shipping address"),           
*                     @OA\Property(property="payment_method_id", 
*                                      type="int",
*                                      example="1",
*                                      description="Payment method"),                     
*                     @OA\Property(property="status", 
*                                      type="string",
*                                      example="ACTIVE",
*                                      description="status"),           
*
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/ 
Flight::route('POST /order', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::orderService()->add_order($data));
});
?>