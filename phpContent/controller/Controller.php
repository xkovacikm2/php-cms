<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 15.7.2015
 * Time: 11:52
 */
namespace controller;

abstract class Controller {

    protected $data = array();
    protected $view = '';
    protected $header = array(
        title => '',
        description => '',
        keywords => ''
    );

    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    abstract public function process($params);

    public function writeView(){
        if($this->view){
            extract($this->preventXSS($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require('view/'.$this->view.'.phtml');
        }
    }

    /**
     * redirects to relative url on site given in param
     * @param $url
     */
    public function redirect($url){
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * function calls htmlspecialchars on every entity recursively
     * @param $arg
     * @return array|null|string
     */
    protected function preventXSS($arg){
        if($arg == null)
            return null;
        if(is_string($arg))
            return htmlspecialchars($arg, ENT_QUOTES);
        if(is_array($arg)){
            foreach ($arg as $iterator => $value){
                $arg[$iterator] = $this->preventXSS($value);
            }
            return $arg;
        }
        return $arg;
    }

    /**
     * adds system message to stack which is displayed after every redirect
     * @param $message
     */
    protected function addSysMessage($message){
        if(isset($_SESSION['sysMessage']))
            $_SESSION['sysMessage'][] = $message;
        else
            $_SESSION['sysMessage'] = array($message);
    }

    /**
     * withdraws all system messages and clears stack
     * @return array
     */
    protected function getSysMessage(){
        if (isset($_SESSION['sysMessage'])){
            $messages = $_SESSION['sysMessage'];
            unset($_SESSION['sysMessage']);
            return $messages;
        }
        return array();
    }
}