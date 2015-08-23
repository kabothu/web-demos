<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos-proj
 * Demo: https://github.com/ilopX/web-demos-proj/tree/master/projects/NetTest
 * This file: https://github.com/ilopX/web-demos-proj/blob/master/libs/NetTest.php
 */

namespace ilopx\libs;

class NetTest{
    const CHECK_ONE_TIME = 1;   // проверять скорость только один раз за сессию
    const CHECK_FIVE_TIME = 5;  // проверять скорость после 5 просмотров
    const CHECK_TEN_TIME = 2;   // проверять скорость через 10 просмотров
    const CHECK_ALWAYS = 3;     // проверять скорость каждый раз

    private $typeCheck;
    private $speed;
    private $sensitivity = 50;

    function __construct($typeCheck = NetTest::CHECK_ALWAYS){
        $this->typeCheck = $typeCheck;
        // генератор проверки скорости
        $this->_generate();
    }

    private function _generate(){
        session_start();

        // Елси проверки на скорость еще не было
        if (!isset($_SESSION['checkNetStatus'])) {
            $this->_start();
        }
        // Если это и есть проверка
        else if ($_SESSION['checkNetStatus'] == 'start'){
            $this->_end();
        }

        $this->_checkType();
    }

    private function _start(){
        $_SESSION['checkNetStatus'] = 'start';
        $_SESSION['checkNetTime'] = microtime(true);
        header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
        exit;
    }

    private function _end(){
        $_SESSION['checkNetStatus'] = 'end';
        $_SESSION['checkNetTime'] = microtime(true)-$_SESSION['checkNetTime'];
    }

    private function _checkType(){
        switch ($this->typeCheck){
            case NetTest::CHECK_ONE_TIME:{
                if (isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetRepeat']);
                }
                break;
            }

            case NetTest::CHECK_FIVE_TIME:{
                if (!isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 5;
                    break;
                }
                if (--$_SESSION['checkNetRepeat'] <= 0){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 5;
                }
                break;
            }

            case NetTest::CHECK_TEN_TIME:{
                if (!isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 10;
                    break;
                }
                if (--$_SESSION['checkNetRepeat'] <= 0){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 10;
                }
                break;
            }

            case NetTest::CHECK_ALWAYS:{
                unset($_SESSION['checkNetStatus']);
                unset($_SESSION['checkNetRepeat']);
                break;
            }

        }
    }

    // возврат количество времени за которое осуществился редирект
    function getTime(){
        return $_SESSION['checkNetTime'];
    }

    function getSpeed(){
        return intval($this->getSpeedFloat());
    }

    function getSpeedFloat(){
        if ($this->speed){
            return $this->speed;
        }

        $this->speed = 101-($this->getTime())*(3 * $this->sensitivity);

        if ($this->speed < 1){
            $this->speed = 1;
        }else if ($this->speed > 100){
            $this->speed = 100;
        }

        return $this->speed;
    }

    function setSensitivity($sensitivity){
        if ($sensitivity < 1)
            $sensitivity = 1;
        else if ($sensitivity > 100)
            $sensitivity = 100;
        $this->sensitivity = $sensitivity;
        $this->speed = null;
    }

    function getSensitivity(){
        return $this->sensitivity;
    }

    function getSpeedName(){
        $speed = $this->getSpeed();
        if ($speed >= 99)
            return "WiFi";
        else if ($speed >= 98)
            return "DSL";
        else if ($speed >= 94)
            return "4G";
        else if ($speed > 90)
            return "Good 3G";
        else if ($speed > 80)
            return "3G";
        else if ($speed > 70)
            return "Good 2G";
        else if ($speed > 30)
            return "2G";
        else
            return "GPRS";
    }

}
