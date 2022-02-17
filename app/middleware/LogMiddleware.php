<?php
namespace app\middleware ;
use app\models\AdminModel ;
use libs\JWT ;
use libs\SecretKey ;
use libs\HttpRequest;
use libs\HtttpResponse;
class LogMiddleware  {
    public $model ;
    function __construct()
    {
        $this->model=new AdminModel();
    }

    public function verify_token(){
        //print_r(HttpRequest::get_header('token'));
        $token_request = HttpRequest::get_header('token')? HttpRequest::get_header('token') :null ;
        //echo $token_request;
        if(!$token_request){
            return false;
        }
        if(JWT::decode($token_request,SecretKey::get_key(),true)){
            $json=JWT::decode($token_request,SecretKey::get_key(),true);
        }else{
            return false;
        }
        //var_dump($json);
        $record_user=$this->model->get_by_id('admin',$json->admin_id);
        //print_r($record_user);
        //unset($record_user['pass']);
        //unset($record_user['token']);
        //var_dump($token_request);


        if((string)$token_request == (string)$record_user['token']){
            return true;
        }
        return false;

    }
}