<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 15.7.2015
 * Time: 13:48
 */
namespace controller;

class ErrorController extends Controller{

    public function __construct(){
        $this->view = 'Error';
    }

    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        header("HTTP/1.0 404 Not Found");

        $this->header['title'] = 'Chyba 404';
    }
}