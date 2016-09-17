<?php

class ValidationManager{

    public static function noEmptyString($string){
        if(isset($string) && $string!= "" && $string!=null){
            return true;
        }
        return false;
    }

    public static function noEmptyArray($array){
        return !empty($array);
    }

}


?>