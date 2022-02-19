<?php
namespace app\controllers ;
//use app\controllers\api\BaseController ;
//use app\models\CategoryModel ;
use app\repositories\CategoryRepo;
use libs\HttpRequest;
use libs\HtttpResponse ;
use app\middleware\LogMiddleware;
use libs\Helper;
class CategoryController  {
    private $category_model;
    public $middle_ware ;
    function __construct()
    {
        $this->category_model = new CategoryRepo();
        $this->middle_ware=new LogMiddleware();
        //parent::__construct();
    }

    public function create(){
        if($this->middle_ware->verify_token()){
            $data = HttpRequest::get_all_field();
            
            //$image = Helper::save($data->url_image,'category');
            $image=$data->url_image?Helper::save($data->url_image,'category'):$data->url_image;

            $respon =$this->category_model->create_category(HttpRequest::get('category_name') , $image);
            if($respon){
                //echo json_encode(array('Message','Created'))  ;
            
                HtttpResponse::response_ok($respon);
            }else{
                //echo json_encode(array('Message','Not Created'))  ;
                HtttpResponse::response_false(array('Message','Not Created'));
            }
        }else{
            HtttpResponse::response_false(array('message','token error'));
        }

    }
    public function update(){
        if($this->middle_ware->verify_token()){
            $data = HttpRequest::get_all_field();
            //print_r($data);

            if(strlen($data->url_image)>200){
                $image=Helper::save($data->url_image,'category');
            }else{
                $image=$data->url_image;
                $image=str_replace('http://localhost:8080/mvc/public/image/','',$image);
            }

            //print_r( HttpRequest::get(('category_id')));
            $respon =$this->category_model->update_category(HttpRequest::get('category_id'), HttpRequest::get('category_name') , $image);
            if($respon){
                //echo json_encode(array('Message','Updated'))  ;
                HtttpResponse::response_ok($respon);
            }else{
                //echo json_encode(array('Message','Not Updated'))  ;
                HtttpResponse::response_false(array('Message','Not Updated'));
            }
        }else{
            HtttpResponse::response_false(array('message','token error'));
        }


    }
    public function  read(){
        if($this->category_model->get_all('category')){
            $data = $this->category_model->get_all('category');

            HtttpResponse::response_ok($data);

            //echo json_encode($data);
        }
    }
    public function delete($id){
        if($this->middle_ware->verify_token()){
            if($this->category_model->delete_by_id('category',$id)){
                //echo json_encode(array('Message','Deleted'))  ;
                HtttpResponse::response_ok(array('Message','Deleted'));
            }else{
                HtttpResponse::response_false(array('Message','Not Deleted'));
                //echo json_encode(array('Message','Not Deleted'))  ;
            }
        }else{
            HtttpResponse::response_false(array('message','token error'));
        }

    }
    public function paging($page_number){
        $data = $this->category_model->get_category_by_page_number($page_number);
        if($data){
            
            HtttpResponse::response_ok($data);
        }
    }

}