class ajax{
    constructor(p_url){
        this.url = p_url;
    }
    post(data, callback){
        $.ajax({
            url: this.url,
            type: "post",
            data: data,
            success: callback,
            error: function(){
                alert("Ein Fehler ist aufgetreten");
            }
        });
    }
}