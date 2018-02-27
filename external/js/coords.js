var canv = document.getElementById('coords');
var parent = document.getElementById('#draw');
var ctx=canv.getContext("2d");
var rectangles;

$(document).ready(function(){
   
    ctx.canvas.height = $('#coords').parent().width() / 3
    ctx.canvas.width = $('#coords').parent().width() / 3
    drawCoordsquare([]);
});


function drawCoordsquare(square){

    ctx.clearRect(0, 0, canv.width, canv.height);
    drawCoord();
    if(Object.keys(square).length == 4){
        var rot = square["rot"];
        var blau = square["blau"];
        var gelb = square["gelb"];
        var gruen = square["gruen"];
        rectangles = square;
        
        
        drawRect(getCanvPos(rot[0]),getCanvPos(rot[1]),getCanvPos(rot[3]),getCanvPos(rot[2]),"rgba(247, 145, 111,0.5)","red");
        drawRect(getCanvPos(gelb[0]),getCanvPos(gelb[1]),getCanvPos(gelb[3]),getCanvPos(gelb[2]),"rgba(249, 255, 140,0.5)","yellow");
        drawRect(getCanvPos(blau[0]),getCanvPos(blau[1]),getCanvPos(blau[3]),getCanvPos(blau[2]),"rgba(111, 247, 233,0.5)","blue");
        drawRect(getCanvPos(gruen[0]),getCanvPos(gruen[1]),getCanvPos(gruen[3]),getCanvPos(gruen[2]),"rgba(96, 255, 123,0.5)","green");
    }
    
}
window.onresize = function(event) {
    var g = document.getElementsByTagName('body')[0];
    canv.width = g.clientHeight / 3;
    canv.height = g.clientHeight / 3;
    drawCoordsquare(rectangles);
};


function drawCoord(){
    var width = canv.getBoundingClientRect().width;
    var height = canv.getBoundingClientRect().height;
    ctx.beginPath();
    ctx.moveTo(width/2,0);
    ctx.lineTo(width/2,height);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(0,height/2);
    ctx.lineTo(width,height/2);
    ctx.stroke();
    
}
function drawRect(a,b,c,d,color,linecolor){
    ctx.beginPath();
    
    ctx.moveTo(a[0][0],a[0][1]);
    ctx.lineTo(b[0][0],b[0][1]);
    ctx.lineTo(c[0][0],c[0][1]);
    ctx.lineTo(d[0][0],d[0][1]);
    ctx.lineTo(a[0][0],a[0][1]);
    ctx.closePath();
    ctx.fillStyle=color;
    ctx.fill();
    ctx.fillStyle="black";
    ctx.strokeStyle = linecolor;
    ctx.stroke();
    ctx.strokeStyle = "black";
    drawPoint(a,5);
    drawPoint(b,5);
    drawPoint(c,5);
    drawPoint(d,5);
}
function getCanvPos(point){
    var width = canv.getBoundingClientRect().width;
    var height = canv.getBoundingClientRect().height;
    
    var arr = [[((point[0]/100) * (width/2))+(width/2),(-1 * ((point[1]/100 * (height/2))))+(height/2)],point];
    return arr;
}
function drawPoint(point,diameter){
    ctx.beginPath();
    ctx.arc(point[0][0],point[0][1],diameter,0,2*Math.PI);
    ctx.stroke();
    ctx.font = "8px Arial";
    ctx.fillText("x: " + Math.round(point[1][0],2) + " | y:" + Math.round(point[1][1],2),point[0][0] + 10,point[0][1] - 10);
    ctx.endPath();
}
