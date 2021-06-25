<?php

Flight::before('start', function(&$params, &$output){
        
    if(Flight::request()->url == '/swagger') return TRUE;
    die("Die message");
 
 
 });
?>