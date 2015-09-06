/**
 * Created by ilopX on 05.09.2015.
 */
$(function(){
    var AjaxNav = {
        nav: $('[role=ajax] li'),
        ajaxContent: $('#ajax-content'),
        tabs: null,
        tabContent: null,
        init: function(){
            $('#noscript-content').remove();

            AjaxNav.createUIContainers();
            AjaxNav.initAjaxNav();

            $(window).on('popstate', function(e){
                if (e.originalEvent.state){
                    AjaxNav.loadData(e.originalEvent.state.url);
                    AjaxNav.nav.checkNavActive();
                }

            });

            AjaxNav.nav.parent().find('.active:first a').click();
        },
        createUIContainers: function(){
            AjaxNav.tabs = $('<ul/>',{
                id: "tabs-mmm",
                class: 'nav nav-tabs'
            });

            AjaxNav.tabContent = $('<div/>',{
                class: 'tab-content',
                id: 'daasdasd'
            });

            AjaxNav.ajaxContent
                .append(AjaxNav.tabs)
                .append(AjaxNav.tabContent);
        },
        initAjaxNav: function(){
            AjaxNav.nav.on('click', 'a', function(e){
                var url = $(this).attr('href');
                AjaxNav.loadData(url);
                AjaxNav.addHistory(url);
                AjaxNav.nav.checkNavActive();
                e.preventDefault();
            })
        },

        loadData: function(url){
            $.ajax({
                url: 'index.php',
                data: {
                    ajaxurl: url
                },

                success: AjaxNav.createUI,
                error: function() {}
            });
        },
        addHistory: function(url, replace){
            var dataSave = {
                title: '111',
                url: url
            };

            if (replace)
                history.replaceState(dataSave, dataSave.title, dataSave.url);
            else
                history.pushState(dataSave, dataSave.title, dataSave.url);
        },
        createUI: function(data){
            AjaxNav.tabContent.empty();
            AjaxNav.tabs.empty();
            AjaxNav.ajaxContent.hide();


            data.forEach(function(item) {
                switch (item['type']) {
                    case 'config':
                        document.title = item['title'];
                        break;
                    case 'live':
                        AjaxNav.addTab(item);
                        AjaxNav.tabs.append(
                            $('<li/>', {
                                style: 'float: right',
                                html:'<a href="'+item['url']+'">Live only</a>'
                            })
                        );
                        break;
                    default:
                        AjaxNav.addTab(item);
                }
            });

            AjaxNav.tabs.find('a:eq(0)').tab('show');
            AjaxNav.ajaxContent.show();
        },

        addTab: function(item){
            var a = $('<a/>',{
                href: '#'+item['id'],
                text: item['name']
            });

            a.attr('data-toggle', 'tab');

            AjaxNav.tabs.append(
                $('<li/>', {
                    html: a
                })
            );

            var tab = $('<div/>', {
                id: item['id'],
                class: 'tab-pane'
            });

            AjaxNav.tabContent.append(tab);

            AjaxNav.setTabContent(item, tab);
        },
        setTabContent: function(item, tab){
            switch (item['type']){
                ////////////////////////////////////////////////////////////////////////
                case 'live':
                    var frame = $('<iframe/>', {
                        src:  item['url'],
                        frameborder: 0
                    }).load(function(){
                        var frameBody = $(frame[0].contentWindow.document.body);
                        frameBody.detectChange('clientHeight',
                            function (oldVal, newVal, isInit) {
                                frame.height(newVal + 20);
                            });
                    });

                    tab.append(frame);
                    break;
                ////////////////////////////////////////////////////////////////////////
                case 'md':
                    tab.append(item['content']);
                    break;
                ///////////////////////////////////////////////////////////////////////
                default:
                    var id = item['id']+'-ace';
                    tab.append('<div id="'+id+'"><div>');
                    var editor = ace.edit(item['id']);
                    editor.$blockScrolling = Infinity;
                    editor.setTheme("ace/theme/tomorrow");
                    editor.session.setMode("ace/mode/"+item['type']);
                    editor.setAutoScrollEditorIntoView(true);
                    editor.setOption("maxLines", 10000);
                    editor.setOption("readOnly", true);
                    editor.getSession().setValue(item['content']);
                    break;
            }
        }

    };
    AjaxNav.init();
});