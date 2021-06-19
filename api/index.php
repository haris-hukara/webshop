<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';

/* include classes */
require_once dirname(__FILE__).'/services/UserAccountService.class.php';
require_once dirname(__FILE__).'/services/UserDetailsService.class.php';

/*

Flight::set('flight.log:errors',TRUE);

 error handling for our API 
Flight::map('error', function(Exception $ex){
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
    }); 
    
*/

Flight::route('GET /', function(){  
    Flight::redirect('/docs');

});


/* utility function for reading params from URL */
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});


/* register Bussiness Logic layer services */
Flight::register('userAccountService', 'UserAccountService');
Flight::register('userDetailsService', 'UserDetailsService');


/* include routes */
require_once dirname(__FILE__).'/routes/userAccount.php';
require_once dirname(__FILE__).'/routes/userDetails.php';
/* get swagger route */
require_once dirname(__FILE__).'/routes/doc.php';


Flight::start();
?>