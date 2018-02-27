$(document).on('click','.calculateButton',function(){
    var poster = new ajax("modules/calculateCoords.php");
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

