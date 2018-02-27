<?php
declare(strict_types=1);
include(dirname(__FILE__) .'\calculateCoords.php')


use PHPUnit\Framework\TestCase;

final class CoordsTest extends TestCase
{
    /*
        Logik zur Berechnung der Punkte 
            Es werden 4 Punkte für ein Viereck erwartet;
           

            ein Punkt pro Viereck wird mit dem übergebenen Prozentsatz berechnet
            ein ander liegt auf dem absoluten Null Punkt

            Zwei Punkte müssen jedoch Zwischen den Hauptpunkten berechnet werden
                Genauer müssen die Schnittpunkte der Achsen berechnet werden.

                Dafür wendet man den Strahlensatz an

    */
    public function testCoordOutput(): void
    {
        $grand_rectangle = new coordsquare([
            "rot" => 80,
            "gelb" => 20,
            "blau" => 40,
            "gruen" => 60
        ]);
        
        $grand_rectangle->calculateIntersectionPoints();
        
        
        
        $this->assertEquals(
            $grand_rectangle->getSubSquareCoords()),
            array(
                "rot" => array(
                    array(-80,80),
                    array(0,32),
                    array(-40/3,0),
                    array(0,0),
                ),
                "gelb" => array(
                    array(0,32),
                    array(20,20),
                    array(0,0),
                    array(10,0),
                ),
                "blau" => array(
                    array(-40/3,0),
                    array(0,0),
                    array(-40,-40),
                    array(-40/3,0),
                ),
                "gruen" => array(
                    array(0,0),
                    array(10,0),
                    array(0,-40/3),
                    array(60,-60),
                ),
            )
        );
    }
}
