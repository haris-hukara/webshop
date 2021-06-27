<?php
/**
 * @OA\Get(path="/admin/orders", tags={"order","admin"},security={{"ApiKeyAuth":{}}},
 *     @OA\Response(response="200", description="List all accounts from database")
 * )
 */
Flight::route('GET /admin/orders', function(){    
    flight::json(Flight::orderService()->get_orders());
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