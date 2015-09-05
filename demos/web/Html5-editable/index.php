<?php
    include_once '../../../vendor/autoload.php';
    $sett = new ilopx\libs\Settings(dirname(__FILE__).'/db');


    if (isset($_REQUEST['id']) && isset($_REQUEST['value'])){
        $id = $_REQUEST['id'];
        $value = $_REQUEST['value'];
        switch ($id){
            case 'name': $sett->set('name', $_REQUEST['value']); break;
            case 'zip': $sett->set('zip', $_REQUEST['value']); break;
        }
        $sett->flush();
        echo $id." save".$_REQUEST['value'];

        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <noscript>
            <div class="alert alert-danger">Javascript disabled. Storing on a server is not available</div>
        </noscript>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit name <span class="glyphicon glyphicon-floppy-saved" style="float: right; display: none"></span></div>
                    <div id="name"  class="panel-body" contenteditable="true">
                        <?= $sett->get('name', 'not set'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit zip <span class="glyphicon glyphicon-floppy-saved" style="float: right; display: none"></span></div>
                    <div id="zip"  class="panel-body" contenteditable="true">
                        <?= $sett->get('zip', 'not set'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="status"></div>
    <script src="/vendor/bower/jquery/dist/jquery.js"></script>
    <script src="index.js"></script>
</body>
</html>