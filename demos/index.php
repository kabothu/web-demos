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


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/bower/bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Web demos projects</h1>
        <h2>Browsers</h2>
        <?php

            $scanned_directory = array_diff(scandir(__DIR__.'/web'), array('..', '.'));
            foreach($scanned_directory as $proj){
                echo "<a href='/demos/web/$proj'>$proj</a><br>";
                if (file_exists($fileReadMe = __DIR__.'/web/'.$proj.'/README.md')){
                    echo MarkdownExtra::defaultTransform(file_get_contents($fileReadMe));
                }
            }
        ?>
        <h2>Console</h2>
        <?php
            $scanned_directory = array_diff(scandir(__DIR__.'/console'), array('..', '.'));
            foreach($scanned_directory as $proj){
                $proj = __DIR__."/console/$proj/run.php";
                if (file_exists($proj)){
                    echo "<code>php $proj</code><br>";
                }

            }
        ?>
    </div>
</body>
</html>
