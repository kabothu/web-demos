<?php
/**
 * Created by PhpStorm.
 * User: XTreme.ws
 * Date: 29.08.2015
 * Time: 18:46
 */

namespace ilopx\demos\index;

use \Michelf\MarkdownExtra;

class Index{
    private $contentReadme;
    private $navWebDemos;
    private $navConsoleDemos;
    private $url;

    public $demosDir;

    function __construct(){
        $this->demosDir = dirname(__DIR__);

        if (isset($_REQUEST['ajaxurl'])){
            echo $this->readmeContent();
            exit;
        }
        else if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/demos/'){
            $host  = $_SERVER['HTTP_HOST'];
            $uri   =  preg_replace('/^\/demos/', '/demos/ibox', $this->firstProject('/web'));
            header("Location: http://{$host}{$uri}");
            exit;
        }
    }


    function isError(){
        $chekFiles = ['index.php', 'index.html', 'index.htm'];
        $url = dirname($this->demosDir).'/'.$this->url();

        foreach($chekFiles as $file){
            if (file_exists($url.'/'.$file)){
                return false;
            }
        }
        return true;
    }

    function url(){
        if (isset($this->url)){
            return $this->url;
        }

        $url = '';
        if (isset($_REQUEST['ajaxurl'])){
            $url = $_REQUEST['ajaxurl'];
        }else if (isset($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];
        }

        $url =  preg_replace('/^\/demos\/ibox/', '/demos', $url);

        return $this->url = $url;
    }

    function firstProject($projDir){
        $dirs = $this->scanDir($projDir);
        if (isset($dirs[2]))
            return "/demos$projDir/".$dirs[2];

        return '';
    }

    function readmeContent(){

        if (!isset($this->contentReadme)){
            if (file_exists($fileReadMe = dirname($this->demosDir).$this->url().'/readme.md'))
                $this->contentReadme = MarkdownExtra::defaultTransform(file_get_contents($fileReadMe));
            else
                $this->contentReadme = '';

        }

        return $this->contentReadme;
    }

    function navWebDemos(){
        if (!isset($this->navWebDemos)){
            $this->navWebDemos = '';
            $dirs = $this->scanDir('/web');
            foreach($dirs as $proj){
                $this->navWebDemos .= "<li><a role='ajax' href='/demos/web/{$proj}'>$proj</a></li>";
            }
        }
        return $this->navWebDemos;
    }

    function navConsoleDemos(){
        if (!isset($this->navConsoleDemos)){
            $this->navConsoleDemos = '';
            $dirs = $this->scanDir('/console');
            foreach($dirs as $proj){
                $proj = __DIR__."/console/$proj/run.php";
                if (file_exists($proj)){
                    $this->navConsoleDemos .= "<code>php $proj</code><br>";
                }
            }
        }

        return $this->navConsoleDemos;
    }

    function render($name){
        $index = $this;
        include_once "render/$name.php";
    }

    private function scanDir($dir){
        return array_diff(scandir($this->demosDir.$dir), array('..', '.', 'index'));
    }
}