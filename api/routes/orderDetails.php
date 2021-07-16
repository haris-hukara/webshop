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
 * @OA\Get(path="/order/price/{id}", tags={"Order Details"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Order ID"),
 *     @OA\Response(response="200", description="Detailed info about order")
 * )
 */
Flight::route('GET /order/price/@id', function($id){
    Flight::json(Flight::orderDetailsService()->get_order_price_by_id($id));  
});
?>