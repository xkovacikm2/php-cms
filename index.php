<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 15.7.2015
 * Time: 11:18
 * Object-oriented redaction system
 */
use controller\RouterController;
use model\database\DBHelper;

session_start();
error_reporting(E_ERROR);
ini_set('display_errors', 'On');
mb_internal_encoding("UTF-8");
spl_autoload_register('classAutoloader');

DBHelper::connect('localhost', 'root', 'root', 'kovko_main');
/**
 * @param $class to be loaded with full namespace
 */
function classAutoloader($class){
    try{
        //replace namespace \ for path / in class name
        $processedClass = str_replace("\\", "/", $class);
        //then try to include it
        if(!include('phpContent/'.$processedClass.'.php'))
            throw new Exception('cannot load '.$class);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->writeView();
