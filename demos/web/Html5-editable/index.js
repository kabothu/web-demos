// находит все обьекты параметр-имя
$('.panel > div:nth-child(2)').blur(function(p){
    var _this = $(this);
    var request = $.ajax({
        url: "index.php",
        method: "POST",
        data: {
            id : _this.attr('id'),
            value: _this.html()
        }
    });

    request.done(function( msg ) {
        _this.prev().find('.glyphicon').stop(true, true).fadeIn().fadeOut('slow')
    });

    request.fail(function( jqXHR, textStatus ) {
       // $( "#status" ).html( "Request failed: " + textStatus );
    });

});
