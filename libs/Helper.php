<?php
namespace libs ;
use libs\HtttpResponse ;
class Helper {
    public static function save($image, $path = '', $name = '')
    {
        try {
            $data = preg_replace('/(data:image\/)|(base64,)/', '', $image);
            list($extension, $base64) = explode(';', $data);
            $decode = base64_decode($base64);
            $filename = empty($name) ? time().'.'.$extension : $name.'.'.$extension;
            $pathNew = './public/image/'.$path.'/';

            //print_r($pathNew.$filename);
            if(!file_exists($pathNew)) {
                mkdir($pathNew, 0777, true);
            }
            if(file_exists($pathNew.$filename)){
                return $path.'/'.$filename;
            }
            file_put_contents($pathNew.$filename, $decode);
            return $path.'/'.$filename;
        } catch (InternalServerException $ex) {

            exit();
        }
    }
}
