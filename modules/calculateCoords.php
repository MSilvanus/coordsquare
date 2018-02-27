<?php 
    class point{
        function __construct($x,$y) {
            $this->X = $x;
            $this->Y = $y;
        }
        function getPointArray(){
            return array($this->X,$this->Y);
        }
    }
    class squarepoint{
        function __construct($percent, $type) {
            
            $this->type = $type;
            switch($this->type){
                case "rot":
                    $this->Y = $percent;
                    $this->X = $percent * -1;
                    break;
                case "blau":
                    $this->X = $percent * -1;
                    $this->Y = $percent * -1;
                    
                    break;
                case "gruen":
                    $this->Y = $percent * -1;
                    $this->X = $percent;
                    break;
                case "gelb":
                    $this->Y = $percent;
                    $this->X = $percent;
                    break;
            }
        }
        function getPointArray(){
            return array($this->X,$this->X);
        }
    }
    class square{
        function __construct($arr_points) {
            if(count($arr_points) == 4){
                $this->points = $arr_points;
            }
        }
    }
    
    class coordsquare extends square{
        function __construct($arr_points_names) {
            if(count($arr_points_names) == 4){
                
                foreach($arr_points_names as $key => $point){
                    $arr_points = $point;
                    $arrPointsObject[$key] = new squarepoint($point, $key);
                }
                parent::__construct($arr_points);
                $this->points_names = $arrPointsObject;
            }
        }
        function calculateIntersectionPoints(){
            $points = $this->points_names;

            if(count($points) == 4){
                    
                    $point_gelb = $points["gelb"];

                    $point_rot = $points["rot"];
                    $point_rot->X = $point_rot->X * -1;

                    $point_blau = $points["blau"];
                    $point_blau->X = $point_blau->X * -1;
                    $point_blau->Y = $point_blau->Y * -1;
                    $point_gruen = $points["gruen"];
                    $point_gruen->X = $point_gruen->X * -1;
                    //Berechnung Y Positiv Rot und Gelb
                    if($point_rot->Y > $point_gelb->Y){
                        $this->intersections["Y_Positiv"] = new point(0, $point_gelb->Y + helper::calculateStrahlensatz($point_gelb,$point_rot,"Y"));
                    }elseif($point_rot->Y < $point_gelb->Y){
                       $this->intersections["Y_Positiv"] =  new point(0, $point_rot->Y +helper::calculateStrahlensatz($point_rot,$point_gelb,"Y"));
                    }elseif($point_rot->Y == $point_gelb->Y){
                        $this->intersections["Y_Positiv"] = new point(0, $point_gelb->X);
                    }

                    //Berechnung X Negativ Rot und Blau
                    if($point_rot->X > $point_blau->X){
                        $this->intersections["X_Negativ"] = new point ($point_blau->X - helper::calculateStrahlensatz($point_blau,$point_rot,"X"), 0) ;
                    }elseif($point_rot->X < $point_blau->X){
                        $this->intersections["X_Negativ"] =  new point ($point_rot->X - helper::calculateStrahlensatz($point_blau,$point_rot,"X"), 0);
                    }elseif($point_rot->X == $point_blau->X){
                        $this->intersections["X_Negativ"] = new point ($point_rot->X, 0);
                    }

                    //Berechnung Y Negativ blau und gruen
                    if($point_blau->Y * -1 > $point_gruen->Y){
                       $this->intersections["Y_Negativ"] = new point(0 , $point_blau->Y - helper::calculateStrahlensatz($point_blau,$point_gruen,"Y"));
                    }elseif($point_blau->Y < $point_gruen->Y){
                        $this->intersections["Y_Negativ"] = new point(0 , $point_gruen->Y - helper::calculateStrahlensatz($point_gruen,$point_blau,"Y"));
                    }elseif($point_blau->Y == $point_gruen->Y){
                        $Y_Axis_Difference["Y_Negativ"] = new point(0,$point_gruen->Y);
                    }
                    //Berechnung X Positiv gruen und gelb
                    if($point_gelb->X * -1 > $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gelb->X + helper::calculateStrahlensatz($point_gelb,$point_gruen,"X"),0);
                    }elseif($point_gelb->X < $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruenX + helper::calculateStrahlensatz($point_gruen,$point_gelb,"X"), 0);
                    }elseif($point_gelb->X == $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruen->X,0);
                    }
                //$this->arr_intersectionPoints["Y_Positv"]
            }
        }
        function getSubSquareCoords(){
            //echo print_r($this->intersections);
            $grand_rectangle = array(
                "rot" => array(
                    $this->points_names["rot"]->getPointArray(),
                    $this->intersections["Y_Positiv"]->getPointArray(),
                    $this->intersections["X_Negativ"]->getPointArray(),
                    array(0,0)
                ),
                "gelb" => array(
                    $this->intersections["Y_Positiv"]->getPointArray(),
                    $this->points_names["gelb"]->getPointArray(),
                    array(0,0),
                    $this->intersections["X_Positiv"]->getPointArray()
                ),
                "blau" => array(
                    $this->intersections["X_Negativ"]->getPointArray(),
                    array(0,0),
                    $this->points_names["blau"]->getPointArray(),
                    $this->intersections["Y_Negativ"]->getPointArray()
                ),
                "gruen" => array(
                    array(0,0),
                    $this->intersections["X_Positiv"]->getPointArray(),
                    $this->intersections["Y_Negativ"]->getPointArray(),
                    $this->points_names["gruen"]->getPointArray()
                    
                ),
            );
            return $grand_rectangle;
        }
    }
    class helper{
        public function strahlenSatz_A($b, $c, $d){
            $a = ($d * $b) / $c;
            return $a;
        }
        public function calculateStrahlensatz($pointLower,$pointHigher,$axis){
            $LPoint = $pointLower;
            $HPoint = $pointHigher;
            if($LPoint->Y < 0){
                $LPoint->Y = $LPoint->Y * -1;
            }
            if($LPoint->X < 0){
                $LPoint->X = $LPoint->X * -1;
            }
            if($HPoint->Y < 0){
                $HPoint->type;
                $HPoint->Y = $HPoint->Y * -1;
            }
            if($HPoint->X < 0){
                $HPoint->X = $HPoint->X * -1;
            }

            if($axis == "Y"){
                $result = helper::strahlenSatz_A(
                    $LPoint->X,
                    $HPoint->X + $LPoint->X,
                    $HPoint->Y - $LPoint->Y
                );
            }else{
                $result = helper::strahlenSatz_A(
                    $HPoint->Y,
                    $HPoint->Y + $pointLower->Y,
                    $HPoint->X - $pointLower->X
                );
            }
            return $result;
        }
    }
    if(isset($_POST["rot"])){
        $grand_rectangle = new coordsquare([
            "rot" => $_POST["rot"],
            "gelb" => $_POST["gelb"],
            "blau" => $_POST["blau"],
            "gruen" => $_POST["gruen"]
        ]);

        $grand_rectangle->calculateIntersectionPoints();
        
        echo( print_r($grand_rectangle->getSubSquareCoords()));
    }
?>
