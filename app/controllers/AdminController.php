<?php

namespace app\controllers ;
use libs\JWT ;
use libs\SecretKey ;
//use app\models\BaseModel;
//use app\models\AdminModel ;
use app\repositories\AdminRepo;
use libs\HtttpResponse;
use libs\HttpRequest;
use app\middleware\LogMiddleware ;
class AdminController  {
    public $admin_repo,$middle_ware;
    function __construct()
    {
        $this->admin_repo=new AdminRepo();
        $this->middle_ware = new LogMiddleware();

    }

    public function login() {
        //HttpRequest::get_all_field();
        $user=HttpRequest::get('admin_name');
        $pass = md5(HttpRequest::get('pass'));

        $data=$this->admin_repo->check_login($user,$pass)?$this->admin_repo->check_login($user,$pass):null;
        if($data){
            unset($data['pass']);
            unset($data['token']);
            //var_dump($data);
            $response = [
                'token'=>$this->create_token($data)
            ];
            $this->admin_repo->update_token($response['token'],$data['admin_id']);
            HtttpResponse::response_ok($response);
        }else{
            HtttpResponse::response_false(array('message','Dang nhap that bai')) ;
        }

    }
    public  function logout(){

        if($this->middle_ware->verify_token()){
            $token_request = HttpRequest::get_header('token')? HttpRequest::get_header('token') :null ;
            $json=JWT::decode($token_request,SecretKey::get_key(),true);
            $record_user=$this->admin_repo->get_by_id('admin',$json->admin_id);
            $id = $record_user['admin_id'];
            //echo $id;
            $this->admin_repo->update_token('',$id);
            HtttpResponse::response_ok(array('message','sucess'));
        }
        else{
            HtttpResponse::response_false(array('token error'));
        }
    }
    public function create_token($data=[]){
        //echo SecretKey::get_key();
        $json_web_token= JWT::encode($data,SecretKey::get_key());
        //var_dump($json_web_token);
        return $json_web_token;
    }

}