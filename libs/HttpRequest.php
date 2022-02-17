<?php
namespace libs ;
class HttpRequest{
    public static function get($field){
        $input = json_decode(file_get_contents('php://input'),1);

        return $input[$field]?htmlspecialchars($input[$field]) : null ;
    }
    public static function get_all_field(){
        $input = json_decode(file_get_contents('php://input'));
        //print_r($input);
        return $input ;
    }
    public static function get_header($name){
        //var_dump($_SERVER);
        $name=strtoupper($name);
        return $_SERVER['HTTP_'.$name];
    }
}