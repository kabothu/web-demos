<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 04.09.2015
 * Time: 19:52
 */

namespace ilopx\demos\index;

use \Michelf\MarkdownExtra;

class Index{
    const DIR_DEMOS_WEB = '/web';
    const DIR_DEMOS_CONSOLE = '/console';

    const DATA_NAV_WEB = 1;
    const DATA_NAV_CONSOLE = 2;
    const DATA_TABS = 3;

    private $demosDir;
    private $url;

    private $dataWebDemos;
    private $dataNavConsole;
    private $dataProjectFile;

    private $_settings;

    function __construct(){
        $this->demosDir = dirname(__DIR__);
        $this->url(); // init var $this->url
        $this->_settings();
    }

    function isAjax(){
        return isset($_REQUEST['ajaxurl']);
    }

    function isRedirect(){
        return isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/demos/';
    }

    function redirect(){
        $host = $_SERVER['HTTP_HOST'];
        $uri =  $this->toAjaxUrl($this->firstProject(Index::DIR_DEMOS_WEB));
        header("Location: http://{$host}{$uri}");
    }

    function render($name){
        $index = $this;
        include_once dirname(__FILE__)."/view/$name.php";
    }

    //////////////////////////// DATA /////////////////////////////////////////////////

    function dataTitle(){
        return $this->isSettings('title', false) ? $this->_settings['title'] : 'Web demos';
    }

    function dataNavWeb(){
        if (!isset($this->dataWebDemos)){
            $this->dataWebDemos = $this->scanDir(Index::DIR_DEMOS_WEB);
        }
        return $this->dataWebDemos;
    }


    function dataNavConsole(){
        if (!isset($this->dataNavConsole)){
            $this->dataNavConsole = $this->scanDir(Index::DIR_DEMOS_CONSOLE);
        }

        return $this->dataNavConsole;
    }
    function dataProjectFile(){
        if ($this->dataProjectFile){
            return $this->dataProjectFile;
        }

        $data = [];
        if ($this->isSettings('live')){
            $data[] = $this->createDataLive('Live');
        }

        if ($this->isSettings('source-files', false)){
            foreach($this->_settings['source-files'] as $file){
                $data[] = $this->createDataFromFile($file);
            }
        }


        return $this->dataProjectFile = $data;
    }

    //////////////////////////// PRIVATE //////////////////////////////////////////////
    //////////////////////////// DATA ////////////////////////////////////////////////
    private function createDataFromFile($name){
        $item = [];
        $fileName = $this->currentDirProject().'/'.$name;
        $item['name'] = $name;
        $item['id'] = strtolower(preg_replace("/[\/\\\\. ]/", '-', $name));
        $item['content'] = file_get_contents($fileName);
        $item['type'] = pathinfo($fileName, PATHINFO_EXTENSION);

        switch($item['type']){
            case 'md':
                $item['content'] = MarkdownExtra::defaultTransform($item['content']);
                break;
            case 'js':
                $item['type'] = 'javascript';
                break;
            case 'htm':
                $item['type'] = 'html';
                break;
        }

        return $item;
    }

    private function createDataLive($name){
        $item['name'] = $name;
        $item['id'] = strtolower(preg_replace("/[\/\\\\. ]/", '-', $name));
        $item['content'] = '';
        $item['type'] = 'live';

        $normalSlise = preg_replace("/[\/\\\\]/", '\/', dirname($this->demosDir));
        $normalPath = preg_replace("/[\/\\\\]/", '/', $this->currentDirProject());
        $item['url'] =  $this->toNormalUrl(preg_replace("/^".$normalSlise."/", '', $normalPath));
        return $item;
    }

    //////////////////////////// UTILS ///////////////////////////////////////////////
    // ���������� ��� �������� ����������
    private function scanDir($dir){
        return array_diff(scandir($this->demosDir.DIRECTORY_SEPARATOR.$dir), array('..', '.', 'index'));
    }

    private function firstProject($dirDemos){
        $dirs = $this->scanDir($dirDemos);
        if (isset($dirs[2]))
            return "/demos$dirDemos/".$dirs[2];

        return '';
    }

    private function toAjaxUrl($url){
        return preg_replace('/^\/demos/', '/demos/ajax', $url);
    }

    private function toNormalUrl($url){
        return preg_replace('/^\/demos\/ajax/', '/demos', $url);
    }

    function url(){
        if (isset($this->url)){
            return $this->url;
        }

        $url = '';
        if ($this->isAjax()){
            $url = $_REQUEST['ajaxurl'];
        }else if (isset($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];
        }

        return $this->url = $url;
    }

    function isThisNav($url){
        return $this->url == $url;
    }

    function isSettings($name, $default = true){
        if (isset($this->_settings[$name])){
            return $this->_settings[$name];
        }
        return $default;
    }

    private function _settings(){
        if ($this->_settings){
            return $this->_settings;
        }

        $fileName_settings = $this->currentDirProject().'/_settings.php';

        $this->_settings = [];
        if (file_exists($fileName_settings)){
            $this->_settings = include $fileName_settings;
        }

        return $this->_settings;
    }

    private function currentDirProject(){
        return dirname($this->demosDir).$this->toNormalUrl($this->url);
    }
}

