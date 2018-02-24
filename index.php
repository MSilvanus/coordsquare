<html>
    <?php 
    include(realpath(dirname(__FILE__)).'\modules\html_build\external_dependencies.php');
    $dependencies = new DependencyList();
    $dependencies->add('Bootstrap Css','external/css/bootstrap.min.css','css');
    $dependencies->add('Stylesheet für index','external/css/style_index.css','css');
    
    $dependencies->add('JQuery','external/js/jquery.min.js','js');
    $dependencies->add('Bootstrap JavaScript','external/js/bootstrap.min.js','js');
    
    $dependencies->add('Ajax Posts','external/js/ajax.js','js');
    $dependencies->add('Button Ereignisse','external/js/buttonhandler.js','js');
    $inputs = Array('rot','gelb','blau','gruen');


    ?>
    <head>
        <?php
            foreach($dependencies->getDependenciesbyType('css') as $stylesheet){
                echo '<link rel="stylesheet" href="' . $stylesheet->source . '"/>';
            }
        ?>
        
        <title>
                Viereck Koordinaten System
        </title>
    </head>
    <body>
        
        <div class="container">

            <div class="jumbotron headline">
                Bitte geben sie Ihre Werte ein.
            </div>
            <div class="form-row">
                <?php
                foreach($inputs as $inputtype){
                ?>
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?php echo $inputtype; ?></div>
                        </div>
                        <input type="text" class="form-control" id="txt_<?php echo $inputtype; ?>" placeholder="% <?php echo $inputtype; ?>">
                    </div>
                </div>
                <?php } ?>
            </div>
            <div>
                <div class="CoordBounds">
                    
                    <label for="txt_bounds">Größe des Koordinatensystems</label>
                    <input type="text" class="form-control" id="txt_bounds" placeholder="in pixel">
                    
                </div>
            </div>
            <button class="btn btn-md btn-outline-success calculateButton" >Berechnen</button>
        </div>
       


        <?php
            foreach($dependencies->getDependenciesbyType('js') as $script){
                echo '<script src="' . $script->source . '"></script>';
            }
        ?>
    </body>
    
</html>