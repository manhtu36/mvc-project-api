<?php

namespace app\models ;

use libs\DB ;

class BaseModel
{
    /**
     * @var DB
     */
    protected $db;

    //protected $table;

    public function __construct()
    {
        $this->db = new DB();
        $this->db->connect();
        $this->db->set_char('utf8');


    }
    public function get_all($table)
    {
        $query = 'select * from ' . $table;
        //echo $query;
        if ($this->db->fetch_assoc($query, 0)) {
            $data = $this->db->fetch_assoc($query, 0);

            return $data;
        }
    }

    public function get_by_id($table, $id)
    {
        $query = 'select * from ' . $table . ' where ' . $table . '_id =' . (int)$id;
        if ($this->db->fetch_assoc($query, 1)) {
            $data = $this->db->fetch_assoc($query, 1);

            return $data;
        }

    }

    public function delete_by_id($table, $id)
    {
        $query = 'delete from ' . $table . ' where ' . $table . '_id=' . (int)$id;
        //echo $query;

        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function get_num_all($table){
        $query = 'select * from ' . $table ;
        $total=$this->db->num_rows($query) ;
        if($total){
            return $total;
        }

    }

}