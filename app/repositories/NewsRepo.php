<?php
namespace app\repositories;
use app\models\NewsModel;
class NewsRepo extends NewsModel{
    public function create_news($category_id,$content,$title,$summary,$create_at,$update_at,$keyword ,$url_image){
        $sql = 'insert into news ( category_id, content,title,summary,create_at,update_at,keyword,url_image) 
                            values (\''.$category_id.'\',\''.$content.'\',\''.$title.'\',\''.$summary.'\',\''.$create_at.'\',\''.$update_at.'\',\''.$keyword.'\',\''.$url_image.'\' )' ;
        //echo $sql;
        if($this->db->query($sql)){
            $id =$this->db->insert_id();

            $data =$this->get_by_id('news',$id);
            return $data;
        }
        else{
            return  false;
        }
    }
    public function update_news($news_id,$category_id,$content,$title,$summary,$create_at,$update_at,$keyword ,$url_image){
        //$sql = 'insert into news ( category_id, content,title,summary,create_at,update_at,keyword,url_image)
        //values (\''.$category_id.'\',\''.$content.'\',\''.$title.'\',\''.$summary.'\',\''.$create_at.'\',\''.$update_at.'\',\''.$keyword.'\',\''.$url_image.'\' )' ;
        //echo $sql;
        $sql = 'update news set category_id ='.$category_id.','.'
        content =\''.$content.'\','.'
        title =\''.$title.'\','.'
        summary =\''.$summary.'\','.'
        create_at =\''.$create_at.'\','.'
        update_at =\''.$update_at.'\','.'
        keyword =\''.$keyword.'\','.'
        url_image =\''.$url_image.'\' where news_id ='.(int)$news_id ;
        //echo $sql;
        if($this->db->query($sql)){
            $data=$this->get_by_id('news',$news_id);
            return $data ;
        }
        else{
            return  false;
        }
    }
    public function search_news($keyword){
        //$keyword=addslashes($keyword);
        $sql='select * from news where keyword like "%'.$keyword.'%" OR title LIKE "%'.$keyword.'%" order by news_id asc;' ;
        //echo  $sql;
        if($this->db->fetch_assoc($sql,0)){
            $data = $this->db->fetch_assoc($sql,0);

            return $data;
        }
        else{
            return false;
        }

    }
    public function get_by_category($category_id){
        $sql='select * from news where category_id ='.$category_id;
        if($this->db->fetch_assoc($sql,0)){
            $data=$this->db->fetch_assoc($sql,0) ;

            return $data;
        }


    }
    public function get_by_page_number( $page_number){
        $start =($page_number-1)*6;
        $end =$start+6 ;
        $query = 'select * from news ORDER BY news_id limit '.$start.','.$end ;
        //echo $query;
        if ($this->db->fetch_assoc($query, 0)) {
            $data = $this->db->fetch_assoc($query, 0);

            return $data;
        }
        else{
            return false;
        }
    }

}