/**
 * Created by XTreme.ws on 30.08.2015.
 */
(function(){
    var Mainnav = {
        contentReadMe: $('#readme'),
        main: $('#main'),
        frame: null,
        nav: $('ul[role=ajax] li'),
        frameBody: function(){
            return $(Mainnav.frame[0].contentWindow.document.body);
        },
        init: function(){
            this.nav.on('click', 'a', function(e){
                e.preventDefault();
                var href = this.getAttribute('href');
                Mainnav.addHistory(href);
                Mainnav.run(href);

            });
            Mainnav.handleState();
            Mainnav.run(location.pathname);
            Mainnav.addHistory(location.pathname, true);

        },
        run: function(url){
            var normalUrl = Mainnav.toNormalUrl(location.pathname);
            Mainnav.nav.checkNavActive({
                url: normalUrl
            });

            Mainnav.loadReadme(url);
            Mainnav.loadIndex(normalUrl);

            $('#run-only').on('click', function(){
                location.href =  normalUrl;
            });
        },
        loadReadme: function(url){
            $.ajax({
                method: 'post',
                url: 'index.php',
                data: {
                    ajaxurl:  Mainnav.toAjaxUrl(url)
                },
                success: function(msg) {
                    if (msg == 'file README.md not exist'){
                        msg = '<div class="alert alert-danger">'+msg+'</div>';
                    }
                    Mainnav.contentReadMe.html(msg);

                },
                error: function() {
                }
            });
        },
        loadIndex: function(url){
            if (Mainnav.frame){
                Mainnav.frame.remove();
            }
            Mainnav.frame = $('<iframe frameborder="0"> ').css({
                width: '100%',
                "overflow": "hidden"
            });
            Mainnav.main.append(Mainnav.frame);
            Mainnav.frame.on('load', function(e){
                Mainnav.frame.height(Mainnav.frameBody().prop('scrollHeight'));
                Mainnav.initAutomaticFrameResize();
                /*$(Mainnav.frame[0].contentWindow.document.body).mutate('height', function(el){
                    console.log('111');
                    if (el.scrollHeight)
                     Mainnav.frame.height(el.scrollHeight);
                });*/
                Mainnav.main.on('resize', function(){
                    console.log('111');
                });

             }).attr('src', Mainnav.toNormalUrl(url));
        },

        toAjaxUrl: function(url){
            return url.replace(/^\/demos(\/ajax)?/, '/demos/ajax');
        },
        toNormalUrl:function(url){
            return url.replace(/^\/demos\/ajax/, '/demos');
        },
        oldSize: null,
        timer: null,
        initAutomaticFrameResize: function(){


        },
        addHistory: function(url, replace){
            var dataSave = {
                title: '1',
                href: Mainnav.toNormalUrl(url),
                url: Mainnav.toAjaxUrl(url)
            };

            if (replace)
                history.replaceState(dataSave, dataSave.title, dataSave.url);
            else
                history.pushState(dataSave, dataSave.title, dataSave.url);
        },
        handleState: function(){
            $(window).on('popstate', function(e){
                if (e.originalEvent.state)
                    Mainnav.run(e.originalEvent.state.url);
            });

        }
    };

    Mainnav.init();
})();