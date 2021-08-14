<?php
/**
 * @OA\Get(path="/products/stock/{id}", tags={"product stock"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Product ID   "),
 *     @OA\Parameter(type="string", in="query", name="size", default="M", description="Product size"),
 *     @OA\Response(response="200", description="Fetch product avaliable quantity")
 * )
 */
Flight::route('GET /products/stock/@id', function($id){
         $size = Flight::query('size');
         Flight::json(Flight::productStockService()->get_product_stock($id, $size));  
});

/**
*  @OA\Post(path="/admin/products/stock",tags={"product stock","admin"}, security={{"ApiKeyAuth": {}}},
*  @OA\RequestBody(description ="Body for product stock", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="product_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Product ID"),           
*                     @OA\Property(property="size_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Size id"),           
*                     @OA\Property(property="quantity_avaliable", 
*                                      type="integer",
*                                      example=10,
*                                      description="Quantity avaliable in stock"),                     
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/ 
Flight::route('POST /admin/products/stock', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::productStockService()->add_product_stock($data));
});

/**
*  @OA\Put(path="/admin/productstock",tags={"product stock","admin"}, security={{"ApiKeyAuth": {}}},
*  @OA\RequestBody(description ="Body for product stock", required = true,
*          @OA\MediaType(mediaType="application/json",
*                 @OA\Schema(
*                     @OA\Property(property="product_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Product ID"),           
*                     @OA\Property(property="size_id", 
*                                      type="integer",
*                                      example=1,
*                                      description="Size id"),           
*                     @OA\Property(property="quantity_avaliable", 
*                                      type="integer",
*                                      example=10,
*                                      description="Quantity avaliable in stock"),                     
*            ) 
*        )
*   ),
*  @OA\Response(response="200", description="Register account")
* )     
*/  
Flight::route('PUT /admin/productstock', function(){
    $data = Flight::request()->data->getdata();
    Flight::json(Flight::productStockService()->update_product_stock($data));
});




?>