(function ( $ ) {
    $.fn.checkNavActive = function(url) {
        if (url == undefined)
            url = location.pathname;

        this.each(function(i, li) {
            li = $(li);
            li.toggleClass('active', url == li.find('a:first').attr('href'));
        });

        return this;
    };
}( jQuery ));


