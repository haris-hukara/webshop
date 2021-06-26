<?php

Flight::before('start', function(&$params, &$output){
        
    if(Flight::request()->url == '/swagger') return TRUE;

    $headers = getallheaders();
    $token = @$headers['Authentication'];
    
    try {
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET",['HS256']);
        Flight::set("decoded", $decoded);
        return TRUE; 
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
   // Flight::middleware();
 });
?>