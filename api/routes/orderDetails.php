<?php
/**
 * @OA\Get(path="/order/details/{id}", tags={"Order Details"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Order ID"),
 *     @OA\Response(response="200", description="Detailed info about order")
 * )
 */
Flight::route('GET /order/details/@id', function($id){
    Flight::json(Flight::orderDetailsService()->get_order_details_by_id($id));  
});

/**
 * @OA\Get(path="/order/details/price/{id}", tags={"Order Details"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Order ID"),
 *     @OA\Response(response="200", description="Detailed info about order")
 * )
 */
Flight::route('GET /order/details/price/@id', function($id){
    Flight::json(Flight::orderDetailsService()->get_order_price_by_id($id));  
});

/**
*  @OA\Post(path="/order/details",tags={"Order Details"},
*  @OA\RequestBody(description ="Body for adding order details", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="order_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="ID of order"),           
*                     @OA\Property(property="product_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Product ID"),           
*                     @OA\Property(property="size_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Size ID"),                     
*                     @OA\Property(property="quantity", 
*                                      type="integer",
*                                      example=1,
*                                      description="Quantity"),           
*
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Added order details")
* )     
*/ 
Flight::route('POST /order/details', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::orderDetailsService()->add_order_details($data));
});


?>