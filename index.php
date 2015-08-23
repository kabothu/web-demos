<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos-proj
 * Demo: todo
 * This file: todo
 */
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Web demos projects</h1>
        <h2>Browsers</h2>
        <?php

            $scanned_directory = array_diff(scandir(__DIR__.'/browser-proj'), array('..', '.'));
            foreach($scanned_directory as $proj){
                echo "<a href='/browser-proj/$proj'>$proj</a><br>";
            }
        ?>
        <h2>Console</h2>
        <?php
            $scanned_directory = array_diff(scandir(__DIR__.'/console-proj'), array('..', '.'));
            foreach($scanned_directory as $proj){
                $proj = __DIR__."/console-proj/$proj/run.php";
                if (file_exists($proj)){
                    echo "<code>php $proj</code><br>";
                }

            }
        ?>
    </div>
</body>
</html>
