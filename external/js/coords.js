$(document).ready(function(){
    var drawElement = document.getElementById('coords');
    var parent = document.getElementById('#draw');
    var ctx=drawElement.getContext("2d");
    ctx.canvas.height = $('#coords').parent().width() / 3
    ctx.canvas.width = $('#coords').parent().width() / 3
    ctx.beginPath();
    ctx.moveTo($('#coords').width()/2,0);
    ctx.lineTo($('#coords').width()/2,$('#coords').height());
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(0, $('#coords').height()/2);
    ctx.lineTo($('#coords').width(),$('#coords').height()/2);
    ctx.stroke();
});

