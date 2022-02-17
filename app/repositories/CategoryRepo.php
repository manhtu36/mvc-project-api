<?php
namespace app\repositories;
use app\models\CategoryModel;

class CategoryRepo extends CategoryModel
{
    public function create_category($category_name, $url_image)
    {
        $sql = 'insert into category (category_name , url_image) values (\'' . $category_name . '\',\'' . $url_image . '\' )';
        //echo $sql;
        if ($this->db->query($sql)) {
            $id =$this->db->insert_id();

            $data =$this->get_by_id('category',$id);
            return $data;
        } else {
            return false;
        }
    }

    public function update_category($category_id, $category_name, $url_image)
    {
        $sql = 'update category set category_name =\'' . $category_name . '\',' . 'url_image =\'' . $url_image . '\'' . 'where category_id =' . (int)$category_id;
        //echo $sql;
        if ($this->db->query($sql)) {
            $data =$this->get_by_id('category',$category_id);
            return $data;
        } else {
            return false;
        }
    }

    public function get_category_by_page_number($page_number)
    {
        $start = ($page_number - 1) * 6;
        $end = $start + 6 - 1;
        $query = 'select * from category ORDER BY category_id limit ' . $start . ',' . $end;
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