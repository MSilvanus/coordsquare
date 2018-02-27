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
            /*
            switch($this->type){
                case "rot":
                    echo print_r(array([$this->X * -1,$this->Y]));
                    $arr_point = array([$this->X * -1,$this->Y]);
                    
                    break;
                case "blau":
                    $arr_point = array([$this->X * -1,$this->Y * -1]);
                    break;
                case "gruen":
                     $arr_point = array([$this->X *-1,$this->Y]);
                    break;
                case "gelb":
                    $arr_point = array([$this->X *-1,$this->Y]);
                    break;
            }*/
            
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
            $this->points_names_bak = &$points;

            if(count($points) == 4){
                    
                    $point_gelb = $points["gelb"];

                    $point_rot = $points["rot"];
                    $point_rot->X = &$point_rot->X * -1;
                    
                    $point_blau = $points["blau"];
                    $point_blau->X = &$point_blau->X * -1;
                    $point_blau->Y = &$point_blau->Y * -1;
                    $point_gruen = $points["gruen"];
                    $point_gruen->X = &$point_gruen->X * -1;

                   
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
                        $this->intersections["X_Negativ"] = new point ($point_rot->X - helper::calculateStrahlensatz($point_rot,$point_blau,"X"), 0);
                    }elseif($point_rot->X == $point_blau->X){
                        $this->intersections["X_Negativ"] = new point ($point_rot->X, 0);
                    }
                    //echo print_r($this->intersections);
                    //Berechnung Y Negativ blau und gruen
                    if($point_blau->Y  > $point_gruen->Y){
                       $this->intersections["Y_Negativ"] = new point(0 , $point_blau->Y - helper::calculateStrahlensatz($point_blau,$point_gruen,"Y"));
                    }elseif($point_blau->Y < $point_gruen->Y){
                        $this->intersections["Y_Negativ"] = new point(0 , $point_gruen->Y - helper::calculateStrahlensatz($point_gruen,$point_blau,"Y"));
                    }elseif($point_blau->Y == $point_gruen->Y){
                        $Y_Axis_Difference["Y_Negativ"] = new point(0,$point_gruen->Y);
                    }
                    //Berechnung X Positiv gruen und gelb
                    if($point_gelb->X > $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gelb->X + helper::calculateStrahlensatz($point_gelb,$point_gruen,"X"),0);
                    }elseif($point_gelb->X < $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruen->X + helper::calculateStrahlensatz($point_gruen,$point_gelb,"X"), 0);
                    }elseif($point_gelb->X == $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruen->X,0);
                    }
                $this->points_names = $this->points_names_bak;
                //$HPoint_X(print_r($this->points_names));
            }
        }
        function getSubSquareCoords(){
            $rot = $this->points_names["rot"]->getPointArray();
            $blau = $this->points_names["blau"]->getPointArray();
            $gelb = $this->points_names["gelb"]->getPointArray();
            $gruen = $this->points_names["gruen"]->getPointArray();

            $Y_Positiv = $this->intersections["Y_Positiv"]->getPointArray();
            $X_Negativ = $this->intersections["X_Negativ"]->getPointArray();
            $X_Positiv = $this->intersections["X_Positiv"]->getPointArray();
            $Y_Negativ = $this->intersections["Y_Negativ"]->getPointArray();

            $grand_rectangle = array(
                "rot" => array(
                    array($rot[0],$rot[1] * -1),
                    $Y_Positiv,
                    $X_Negativ,
                    array(0,0)
                ),
                "gelb" => array(
                    $Y_Positiv,
                    $gelb,
                    array(0,0),
                    $X_Positiv
                ),
                "blau" => array(
                    $X_Negativ,
                    array(0,0),
                    array($blau[0],$blau[1]),
                    $Y_Negativ
                ),
                "gruen" => array(
                    array(0,0),
                    $X_Positiv,
                    $Y_Negativ,
                    array($gruen[0],$gruen[1]*-1)
                    
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
            $fuckphp1  = &$pointLower;
            $fuckphp2  = &$pointHigher;
            unset($pointLower);
            unset($pointHigher);
            $LPoint = $fuckphp1;
            $HPoint = $fuckphp2;
            $LPoint_Y = $LPoint->Y;
            $LPoint_X = $LPoint->X;
            $HPoint_Y = $HPoint->Y;
            $HPoint_X = $HPoint->Y;
            if($LPoint_Y < 0){
                $LPoint_Y = $LPoint_Y * -1;
            }
            if($LPoint_X < 0){
                $LPoint_X = $LPoint_X * -1;
            }
            if($HPoint_Y < 0){

                $HPoint_Y = $HPoint_Y * -1;
            }
            if($HPoint_X < 0){
                $HPoint_X = $HPoint_X * -1;
            }
            if($axis == "Y"){
                $result = helper::strahlenSatz_A(
                    $LPoint_X,
                    $HPoint_X + $LPoint_X,
                    $HPoint_Y - $LPoint_Y
                );
            }else{
                $result = helper::strahlenSatz_A(
                    $LPoint_Y,
                    $HPoint_Y + $LPoint_Y,
                    $HPoint_X - $LPoint_X
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
        
        
        $JSONreturn = json_encode($grand_rectangle->getSubSquareCoords());
       // $HPoint_X print_r($grand_rectangle->points_names);
        echo $JSONreturn;
    }
?>
