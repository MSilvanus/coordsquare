<?php 
include(dirname(dirname(__FILE__)) .'\utility.php') ;

class DependencyList{
    public $arr;
    public function getDependenciesbyType($p_type){
        $r_arr = array();
        foreach($this->arr as $dependency){
            if($dependency->type == $p_type){
                $r_arr = helperfunctions::addToArray($r_arr,$dependency);
            }
        }
        return $r_arr;
    }
    public function add($p_name, $p_source, $p_type){
       
       $this->arr = helperfunctions::addToArray($this->arr, new Dependency($p_name,$p_source,$p_type));
       
    }
}

class Dependency{
    public $name;
    public $source;
    public $type;

    public function __construct($p_name,$p_source,$p_type){
        $this->name = $p_name;
        $this->source = $p_source;
        $this->type = $p_type;
    }
}

?>