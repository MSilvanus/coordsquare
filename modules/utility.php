<?php
    class helperfunctions{
        public static function addToArray($arr,$value){
            $r_arr = $arr;
            
            
            if (empty($arr)){
                $r_arr = array($value);
            }else{
                $r_arr[] = $value;
            }
           
            return $r_arr;
        }
    }
    
?>