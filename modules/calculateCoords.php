<?php 
/**
* //Entspricht einem Punkt im Coordinatensystem
*
* @author   Marcel Silvanus
* @version  1.0
* @category Coordinaten
*/
    class point{
        function __construct($x,$y) {
            $this->X = $x;
            $this->Y = $y;
        }
        function getPointArray(){
            return array($this->X,$this->Y);
        }
    }
/**
* //Entspricht einem Punkt ein Einem Viereck
*
* @author   Marcel Silvanus
* @version  1.0
* @category Coordinaten
*/
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
/**
* //Entspricht einem Viereck
*
* @author   Marcel Silvanus
* @version  1.0
* @category Figuren
*/
    class square{
        function __construct($arr_points) {
            if(count($arr_points) == 4){
                $this->points = $arr_points;
            }
        }
    }
/**
* //Entspricht einem Farb-Viereck
*
* @author   Marcel Silvanus
* @version  1.0
* @category Coordinaten
*/
    class coordsquare extends square{
    /**
    * Wenn vier Prozentzahlen übergeben werden initialisiert die Punkte
    *
    * @param Array der Punkte
    *
    *
    */
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
        /**
        * Berechnet die Schnittstellen mit den Axen
        */
        function calculateIntersectionPoints(){
            $points = $this->points_names;
            //Wenn vier Punkte
            if(count($points) == 4){
                    //Initialisierung der Punkte Arrays
                    $point_gelb = $points["gelb"];

                    $point_rot = $points["rot"];
                    $point_rot->X = &$point_rot->X * -1;
                    
                    $point_blau = $points["blau"];
                    $point_blau->X = &$point_blau->X * -1;
                    $point_blau->Y = &$point_blau->Y * -1;
                    $point_gruen = $points["gruen"];
                    $point_gruen->X = &$point_gruen->X * -1;

                    //Für jedes Farbviereck wurde eine Fallunterscheidung entworfen, die bestimmt welcher Punkt höher ist Zum Schluss erhält man ein Array in dem die Schnittpunkte sind
                   
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
                    //Berechnung Y Negativ blau und gruen
                    if($point_blau->Y  > $point_gruen->Y){
                       $this->intersections["Y_Negativ"] = new point(0 , $point_blau->Y - helper::calculateStrahlensatz($point_blau,$point_gruen,"Y"));
                    }elseif($point_blau->Y < $point_gruen->Y){
                        $this->intersections["Y_Negativ"] = new point(0 , $point_gruen->Y - helper::calculateStrahlensatz($point_gruen,$point_blau,"Y"));
                    }elseif($point_blau->Y == $point_gruen->Y){
                        $this->intersections["Y_Negativ"] = new point(0, $point_gruen->Y);
                    }
        
                    //Berechnung X Positiv gruen und gelb
                    if($point_gelb->X > $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gelb->X + helper::calculateStrahlensatz($point_gelb,$point_gruen,"X"),0);
                    }elseif($point_gelb->X < $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruen->X + helper::calculateStrahlensatz($point_gruen,$point_gelb,"X"), 0);
                    }elseif($point_gelb->X == $point_gruen->X){
                        $this->intersections["X_Positiv"] = new point($point_gruen->X,0);
                    }

                //$HPoint_X(print_r($this->points_names));
            }
        }
        /**
        * Gibt ein Array zurück, dass die Koordinaten der Vier Farbvierecke zurück gibt
        *
        *
        *
        *
        * @return Folgendes Array mit Beispiel Daten
        *array(
        *        "rot" => array(
        *            array(-80,80),
        *            array(0,32),
        *            array(-40/3,0),
        *            array(0,0),
        *        ),
        *        "gelb" => array(
        *            array(0,32),
        *            array(20,20),
        *            array(0,0),
        *            array(10,0),
        *        ),
        *        "blau" => array(
        *            array(-40/3,0),
        *            array(0,0),
        *            array(-40,-40),
        *            array(-40/3,0),
        *        ),
        *        "gruen" => array(
        *            array(0,0),
        *            array(10,0),
        *            array(0,-40/3),
        *            array(60,-60),
        *        ),
        *    )
        */
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
/**
* //Enthält statische Hilfsfunktionen
*
* @author   Marcel Silvanus
* @version  1.0
* @category Hilfe
*/

    
    class helper{
        /**
        * Funktion des Strahlensatzes der die Seite a ausgibt
           
        * @param b, c, d
        * @todo Die Kupplung darf nicht einfach losgelassen werden!
        *
        * @return bool
        */
        public function strahlenSatz_A($b, $c, $d){
            $a = ($d * $b) / $c;
            return $a;
        }
        /**
            *verhindert NegativWerte und unterscheidet nach Axe
        */
        public function calculateStrahlensatz($pointLower,$pointHigher,$axis){
            
            $LPoint = &$pointLower;
            $HPoint = &$pointHigher;
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
    //Post Funktion gibt das Viereck Array in JSON zurück
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
