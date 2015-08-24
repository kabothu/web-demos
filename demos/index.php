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
$contentReadme = '';

if (isset($_REQUEST['readmeUrl'])){
    if (file_exists($fileReadMe = __DIR__.$_REQUEST['readmeUrl'])){
        $contentReadme = MarkdownExtra::defaultTransform(file_get_contents($fileReadMe));
    }

    if (isset($_REQUEST['getAjax']) && $_REQUEST['getAjax']){
        echo $contentReadme;
        exit;
    }

}

$webDemos = '';
$scanned_directory = array_diff(scandir(__DIR__.'/web'), array('..', '.'));
foreach($scanned_directory as $proj){
    $readme = '';
    $fileReadMe = '/web/'.$proj.'/README.md';
    if (file_exists(__DIR__.$fileReadMe)){
        $fileReadMe = " data-readme-url=\"$fileReadMe\"";
    }
    $webDemos .= "<li><a role='ajax' href='/demos/web/{$proj}'{$fileReadMe}>$proj</a><br></li>";
}

$consoleDemos = '';
$scanned_directory = array_diff(scandir(__DIR__.'/console'), array('..', '.'));
foreach($scanned_directory as $proj){
    $proj = __DIR__."/console/$proj/run.php";
    if (file_exists($proj)){
        $consoleDemos .= "<code>php $proj</code><br>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="col-md-3">
            <?php if ($webDemos): ?>
                <h2>Browsers</h2>
                <ul class="nav nav-pills nav-stacked"><?= $webDemos ?></ul>
            <?php endif; ?>

            <?php if ($webDemos): ?>
                <h2>Console</h2>
                <ul class="nav nav-pills nav-stacked"><?= $consoleDemos ?></ul>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <h1>Web demos projects</h1>


            <ul id="myTabs" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                <li class="active"><a href="#project" id="home-tab"  data-toggle="tab" >Home</a></li>
                <li><a href="#readme"  id="profile-tab" data-toggle="tab">Profile</a></li>
            </ul>
            <div id="myTabContent" class="tab-content" style="padding: 10px">
                <iframe class="tab-pane fade in active" id="project" style="width: 100%!important;" frameborder="0">
                </iframe>
                <div class="tab-pane fade" id="readme">
                    <?= $contentReadme ?>
                </div>
            </div>

        </div>

    </div>
    <script src="/vendor/bower/jquery/dist/jquery.js"></script>
    <script src="/vendor/bower/bootstrap/dist/js/bootstrap.js"></script>
    <script>
        function autoResize(id){
            var newheight;

            if(document.getElementById){
                newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
            }

            document.getElementById(id).height= (newheight) + "px";
        }
        $('[role=ajax]').click(function(){
            var _this = $(this);
            $('#project').attr('src', _this.attr('href')).load(function(){
                autoResize('project');
            });

            if (_this.attr('data-readme-url')){
                $.ajax({
                   // method: 'GET',
                    url: 'index.php',
                    data: {
                        readmeUrl: _this.attr('data-readme-url'),
                        getAjax: true
                    },
                    success: function(msg) {
                        $('#readme').html(msg);
                    },
                    error: function() {
                        // TODO add message error
                    }
                });
            }
            return false;
        });
    </script>
</body>
</html>
