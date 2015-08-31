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

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-2">
            <?php $index->render('nav'); ?>
        </div>
        <div class="col-md-10">
            <h1>Web demos projects</h1>
            <?php $index->render('tabs'); ?>
        </div>
    </div>
    <script src="/vendor/bower/jquery/dist/jquery.js"></script>
    <script src="/vendor/bower/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/vendor/bower/jquery-mutate/js/events.js"></script>
    <script src="/vendor/bower/jquery-mutate/js/mutate.js"></script>
    <script src="/demos/index/jquery.check-nav-active.js"></script>
    <script src="/demos/index/Mainnav.js"></script>
</body>
</html>
