/**
 * Created by XTreme.ws on 29.08.2015.
 */


var lastActiveNav = null;
var webDemos = $('[href^="/demos/web"]');


function projectRun(urlProject){

    var project = document.getElementById('project');
    project.onload = function(){
        // resize frame
        var frameBody = $(this.contentWindow.document.body);
        project.height= frameBody[0].scrollHeight+'px';
        frameBody.mutate('height', function(el){
            if (el.scrollHeight)
                project.height= el.scrollHeight+'px'
        });

        document.getElementById('run-only').onclick = function(){
            location.href = urlProject;
        };
    };
    project.setAttribute('src', urlProject);


    var currUrl = urlProject.replace(/^\/demos/, '/demos/ibox');
    history.pushState(null, null, currUrl);

    $.ajax({
        method: 'post',
        url: 'index.php',
        data: {
            ajaxurl:  currUrl
        },
        success: function(msg) {
            $('#readme').html(msg);

        },
        error: function() {
        }
    });

    webDemos.checkNavActive({url: location.pathname.replace(/^\/demos\/ibox/, '/demos')});

    return false;
}

var nav = $('a[role=ajax]')
    .click(function(){
        projectRun(this.getAttribute('href'));
        return false;
    });

projectRun(location.pathname.replace(/^\/demos\/ibox/, '/demos'));