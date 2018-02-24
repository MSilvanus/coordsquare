<?php
global $coord_bounds = $_POST["bounds"];

class point{
    public X;
    public Y;

    public function __construct($percent,$type){
        this->X = ($coord_bounds/2)*($percent/100);
        this->Y = this->X

        switch($type){
            case "rot":
                this->X = this->X * -1
                break;
            case "blau":
                this->X = this->X * -1
                this->Y = this->Y * -1
                break;
            case "gruen":
                this->Y = this->Y * -1
                break;
        }
    }
}

?>

