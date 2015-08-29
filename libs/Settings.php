<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos-proj
 * This file: https://github.com/ilopX/web-demos-proj/blob/master/libs/Settings
 * Demo:
    $a = new Settings(dirname(__FILE__).'/db');
    $a->setParam('a', file_get_contents('fileName'));
    $a->setParam('b', 1);
    $a->setParam('c', true);
    $a->setParam('d', 'string');
 */

namespace ilopx\libs;

class Settings {
    private $fileName;
    private $arr = [];
    private $change = false;

    function __construct($fileName, $array = []){
        $this->arr = $array;
        $this->fileName = $fileName;
        if (file_exists($fileName)){
            $this->arr = unserialize(gzdecode(file_get_contents($fileName)));
        }
    }

    function __destruct(){
        $this->flush();
    }

    function flush(){
        if ($this->change){
            file_put_contents($this->fileName, gzencode(serialize($this->arr)));
            $this->change = false;
        }

    }

    function set($name, $value){
        $this->arr[$name] = $value;
        $this->change = true;
    }

    function get($name, $default = ''){
        if (isset($this->arr[$name])){
            return $this->arr[$name];
        }

        return $default;
    }

}

