<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos-proj
 * Demo: https://github.com/ilopX/web-demos-proj/tree/master/projects/NetTest
 * This file: https://github.com/ilopX/web-demos-proj/blob/master/projects/NetTest/example.php
 */

include_once '../../vendor/autoload.php';

use ilopx\libs\NetTest;

$netTest = new NetTest();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.css">
</head>
<body class="container">
<?php

$netTest->setSensitivity(isset($_GET['sensitivity']) ? $_GET['sensitivity'] : 50);
echo 'time: ', $netTest->getTime(), '<br>';
echo 'speed: 100/', $netTest->getSpeed(), '<br>';
echo $netTest->getSpeedName();

?>
</body>
</html>
