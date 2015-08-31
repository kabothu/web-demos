(function ( $ ) {
    $.fn.checkNavActive = function(options) {
        var set = $.extend({
            url: location.pathname
        }, options);

        this.each(function(i, li) {
            li = $(li);
            li.toggleClass('active', set.url == li.find('a:first').attr('href'));
        });

        return this;
    };
}( jQuery ));


