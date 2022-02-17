<?php
namespace app\controllers ;
//use app\models\NewsModel ;
use app\repositories\NewsRepo;
use libs\HttpRequest;
use libs\HtttpResponse ;
use app\middleware\LogMiddleware;
use libs\Helper;
class NewsController  {
    private $news_model ;
    public $middle_ware;
    function __construct()
    {
        $this->news_model=new NewsRepo();
        $this->middle_ware=new LogMiddleware();
        //parent::__construct();
        //$this->middle_ware=$this->get_middleware();
        //var_dump($this->middle_ware);

    }

    public function create(){
        if($this->middle_ware->verify_token()) {
            $data = HttpRequest::get_all_field();
            //print_r($data);
            $image=$data->url_image?Helper::save($data->url_image,'news'):$data->url_image;
            $respon=$this->news_model->create_news(HttpRequest::get('category_id'),HttpRequest::get('content') , HttpRequest::get('title'),HttpRequest::get('summary'),HttpRequest::get('create_at'),HttpRequest::get('update_at'),HttpRequest::get('keyword'),$image);

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
            $image=$data->url_image?Helper::save($data->url_image,'news'):$data->url_image;
            $respon =$this->news_model->update_news(HttpRequest::get('news_id'),HttpRequest::get('category_id'),HttpRequest::get('content') , HttpRequest::get('title'),HttpRequest::get('summary'),HttpRequest::get('create_at'),HttpRequest::get('update_at'),HttpRequest::get('keyword'),$image);
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

    public function  read_by_id($news_id){
        if($this->news_model->get_by_id('news',$news_id)){
            $data = $this->news_model->get_by_id('news',$news_id);

            HtttpResponse::response_ok($data);
            //echo json_encode($data);
        }
    }
    public function delete($id){
        //var_dump($this->middle_ware);
        if($this->middle_ware->verify_token()){
            if($this->news_model->delete_by_id('news',$id)){
                //echo json_encode(array('Message','Deleted'))  ;
                HtttpResponse::response_ok(array('Message','Deleted'));
            }else{
                //echo json_encode(array('Message','Not Deleted'))  ;
                HtttpResponse::response_false(array('Message','Not Deleted'));
            }
        }else{
            HtttpResponse::response_false(array('message','token error'));
        }


    }
    public function search(){
        $keyword = HttpRequest::get('keyword');
        if($this->news_model->search_news($keyword)){
            $data=$this->news_model->search_news($keyword);

            //echo json_encode($data);
            HtttpResponse::response_ok($data);
        }

    }
    public function read_by_category($category_id){
        if($this->news_model->get_by_category($category_id)){
            $data = $this->news_model->get_by_category($category_id);

            //echo json_encode($data);
            HtttpResponse::response_ok($data);
        }
    }
    public function read_all(){
        $data = $this->news_model->get_all('news');
        if($data){

            HtttpResponse::response_ok($data);
            //echo json_encode($data);
        }
    }
    public function paging($page_number=1){
        $data = $this->news_model->get_by_page_number($page_number);
        if($data){

            HtttpResponse::response_ok($data);
        }


    }
    public function total_record(){
        $data = $this->news_model->get_num_all('news');
        if($data){

            HtttpResponse::response_ok($data);
            //echo json_encode($data);
        }
    }
}