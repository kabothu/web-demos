(function ( $ ) {
    $.fn.checkNavActive = function(options) {
        var set = $.extend({
            url: location.pathname
        }, options);

        return this.each(function(i, a) {
            if (set.url == a.getAttribute('href')) {
                if (lastActiveNav) {
                    lastActiveNav.removeClass('active');
                }
                lastActiveNav = $(a).parent().addClass('active');

                return false;
            }
        });
    };

}( jQuery ));


