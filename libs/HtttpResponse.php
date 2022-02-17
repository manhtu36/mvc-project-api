<?php
namespace libs ;
class HtttpResponse{
    public static function response_ok($data){
        http_response_code(200);

        echo json_encode($data);
    }
    public static function response_false($message){
        http_response_code(401);
        echo json_encode($message);
    }
}