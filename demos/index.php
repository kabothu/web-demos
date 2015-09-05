<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos
 * Demo: todo
 * This file: todo
 */

include_once '../vendor/autoload.php';

use ilopx\demos\index\Index;

$index = new Index();
if ($index->isAjax()){
    header('Content-type: application/json');
    echo json_encode($index->dataProjectFile());
    exit;
}
else if ($index->isRedirect()){
    $index->redirect();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/demos/index/index.css">
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-2">
            <?php $index->render('nav'); ?>
        </div>
        <div class="col-md-10">
            <h1>Web demos projects</h1>
            <noscript><?php $index->render('content'); ?></noscript>
            <div id="ajax-content"></div>
        </div>
    </div>
    <script src="/vendor/bower/jquery/dist/jquery.js"></script>
    <script src="/vendor/bower/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/demos/index/jquery.check-nav-active.js"></script>
    <script src="/vendor/bower/ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/vendor/bower/ilopx-jquery-detect-change/dist/jquery.detect-change.js"></script>
    <script src="/demos/index/AjaxNav.js"></script>
    <script>
        // Create ace editors
        /*var index = 0;
        $('textarea').each(function(i, el){
            index++;
            el = $(el).attr('id', 'editor'+index);

            var editor = ace.edit('editor'+index);
            editor.$blockScrolling = Infinity;
            editor.getSession().setValue(el.val());
            editor.setTheme("ace/theme/tomorrow");
            editor.session.setMode("ace/mode/"+el.attr('data-file-type'));
            editor.setAutoScrollEditorIntoView(true);
            editor.setOption("maxLines", 10000);
            editor.setOption("readOnly", true);
        });*/
    </script>
    <script>
        // Create auto size main frame
        /*$(function() {
         var msetHook = false;
         var mainFrame = $('#main-frame');
         function setHook()
         {
         if (msetHook)
         return;
         msetHook = true;

         var frameBody = $(mainFrame[0].contentWindow.document.body);
         frameBody.detectChange('clientHeight',
         function (oldVal, newVal, isInit)
         {
         mainFrame.height(newVal + 20);

         });
         }

         mainFrame.load(setHook);*/
        });
    </script>
</body>
</html>
