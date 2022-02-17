<?php
namespace app\repositories ;
use app\models\AdminModel;
//use app\models\BaseModel;
class AdminRepo extends AdminModel{
    public function check_login($user_name , $pass){
        $sql = 'select * from admin where admin_name ="'.$user_name.'" and pass="'.$pass.'"' ;

        if($this->db->num_rows($sql)===1){
            $data=$this->db->fetch_assoc($sql,1);
            return $data;
        }
        return false;
    }
    public function update_token($token,$id){
        $sql = 'update admin set token ="'.$token.'"'.' where admin_id = '.$id;
        //echo $sql;

        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}
