<?php

class Config {

    const DATE_FORMAT = "Y-m-d H:i:s";
    const DB_HOST = "localhost";
    const DB_USERNAME = "webshop";
    const DB_PASSWORD = "webshop";
    const DB_SCHEME = "webshop";

      public static function SMTP_HOST(){
        return Config::get_env("SMTP_HOST", "smtp.gmail.com");
      }
      public static function SMTP_PORT(){
        return Config::get_env("SMTP_PORT", "587");
      }
      public static function SMTP_USER(){
        return Config::get_env("SMTP_USER", "");
      }
      public static function SMTP_PASSWORD(){
        return Config::get_env("SMTP_PASSWORD", "");
      }
      public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
      }

}   

?>