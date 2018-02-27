$(document).on('click','.calculateButton',function(){
    var sections = ["rot","gelb","blau","gruen"]
    var poster = new ajax("modules/calculateCoords.php");
    sections.forEach(function(element) {
        console.log($("#txt_" + element).val());
        if(!$.isNumeric($("#txt_" + element).val()) || $("#txt_" + element).val() > 100){
            alert("Bitte geben Sie in " + element +" eine Zahl unter Hundert ein.");
            return false;
        }
    }, this);
    poster.post({
        rot: $('#txt_rot').val(),
        gelb: $('#txt_gelb').val(),
        blau: $('#txt_blau').val(),
        gruen: $('#txt_gruen').val(),
        bounds: $('#txt_bounds').val()
    },function(data){
        try{
            var rectangles = JSON.parse(data);
            drawCoordsquare(rectangles);
        }
        catch(e){
            alert("Fehler: Server - " + data + " Client - " + e.message);
        }
    });
});

