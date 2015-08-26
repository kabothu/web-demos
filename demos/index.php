<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://ilopX.github.io/web-demos
 * Demo: todo
 * This file: todo
 */

include_once '../vendor/autoload.php';


use \Michelf\MarkdownExtra;

class Index{
    private $contentReadme;
    private $navWebDemos;
    private  $navConsoleDemos;

    function __construct(){
        if (isset($_REQUEST['ajaxreadme'])){
            echo $this->readmeContent();
            exit;
        }
    }

    function readmeContent(){
        if (!isset($this->contentReadme)){
            $url = isset($_REQUEST['ajaxreadme']) ? $_REQUEST['ajaxreadme']: $_SERVER['REQUEST_URI'];
            if ($url == '/demos/'){
                $dirs = $this->scanDir('/web');
                if (isset($dirs[2]))
                    $url = '/demos/web/'.$dirs[2];
            }
            else{
                $url = preg_replace('/^\/demos\/ibox/', '/demos', $url);
            }

            if (file_exists($fileReadMe = dirname(__DIR__).$url.'/readme.md'))
                $this->contentReadme = MarkdownExtra::defaultTransform(file_get_contents($fileReadMe));
            else
                $this->contentReadme = '';

        }

        return $this->contentReadme;
    }

    function navWebDemos(){
        if (!isset($this->navWebDemos)){
            $this->navWebDemos = '';
            $dirs = $this->scanDir('/web');
            foreach($dirs as $proj){
                $this->navWebDemos .= "<li><a role='ajax' href='/demos/web/{$proj}'>$proj</a></li>";
            }
        }
        return $this->navWebDemos;
    }

    function navConsoleDemos(){
        if (!isset($this->navConsoleDemos)){
            $this->navConsoleDemos = '';
            $dirs = $this->scanDir('/console');
            foreach($dirs as $proj){
                $proj = __DIR__."/console/$proj/run.php";
                if (file_exists($proj)){
                    $this->navConsoleDemos .= "<code>php $proj</code><br>";
                }
            }
        }

        return $this->navConsoleDemos;
    }

    private function scanDir($dir){
        return array_diff(scandir(__DIR__.$dir), array('..', '.'));
    }
}

$index = new Index();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-2">
            <?php if ($index->navWebDemos()): ?>
                <h2>Browsers</h2>
                <ul class="nav nav-pills nav-stacked"><?= $index->navWebDemos() ?></ul>
            <?php endif; ?>

            <?php if ($index->navConsoleDemos()): ?>
                <h2>Console</h2>
                <ul class="nav nav-pills nav-stacked"><?= $index->navConsoleDemos() ?></ul>
            <?php endif; ?>
        </div>
        <div class="col-md-10">
            <h1>Web demos projects</h1>
            <ul id="myTabs" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                <li class="active"><a href="#project" data-toggle="tab" >Home</a></li>
                <li><a href="#readme"  data-toggle="tab">Readme.md</a></li>
                <li><a id="run-only" href="#" data-toggle="tab">Run only</a></li>
            </ul>
            <div id="myTabContent" class="tab-content" style="padding: 10px">
                <noscript><div>
                        <div class="alert alert-danger">JavaScript is Disabled</div>
                </noscript>
                <iframe class="tab-pane fade in active" id="project" style="width: 100%!important;" frameborder="0">
                </iframe>
                <div class="tab-pane fade" id="readme">
                    <?= $index->readmeContent() ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/vendor/bower/jquery/dist/jquery.js"></script>
    <script src="/vendor/bower/bootstrap/dist/js/bootstrap.js"></script>
    <script>

        var lastActiveNav = null;
        var webDemos = $('[href^="/demos/web"]');


        function projectRun(src){
            $('#project').attr('src',  src).load(function(){
                if (document.getElementById) {
                    var proj = document.getElementById('project');
                    proj.height= proj.contentWindow.document.body.scrollHeight+ "px";
                    document.getElementById('run-only').onclick = function(){
                        location.href = src;
                    };
                }
            });

            history.pushState(null, null, src.replace(/^\/demos/, '/demos/ibox'));
            var url = location.pathname.replace(/^\/demos\/ibox/, '/demos');

            webDemos.each(function(i, a) {

                if (url == a.getAttribute('href')) {
                    if (lastActiveNav) {
                        lastActiveNav.removeClass('active');
                    }
                    console.log('set');
                    lastActiveNav = $(a).parent().addClass('active');

                    return false;
                }
            });
        }

        var nav = $('a[role=ajax]')
            .click(function(){
                var _this = $(this);

                projectRun( _this.attr('href'));

                $.ajax({
                    method: 'post',
                    url: 'index.php',
                    data: {
                        ajaxreadme:  _this.attr('href')
                    },
                    success: function(msg) {
                        $('#readme').html(msg);

                    },
                    error: function() {
                    }
                });

                return false;
            });

        if (location.pathname == '/demos/'){
            if (nav.length){
                nav.eq(0).click();
            }
        }else{
            projectRun(location.pathname.replace(/^\/demos\/ibox/, '/demos'));
        }
    </script>
</body>
</html>
