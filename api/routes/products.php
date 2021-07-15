<?php
/**
 * @OA\Get(path="/products/stock/{id}", tags={"products"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Product ID   "),
 *     @OA\Parameter(type="string", in="query", name="size", default="M", description="Product size"),
 *     @OA\Response(response="200", description="Fetch product avaliable quantity")
 * )
 */
Flight::route('GET /products/stock/@id', function($id){
         $size = Flight::query('size');
         Flight::json(Flight::productsService()->get_product_stock($id, $size));  
});

?>