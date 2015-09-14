<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 15.7.2015
 * Time: 12:24
 */
namespace controller;

class RouterController extends Controller{

    protected $controller;

    public function __construct(){
        $this->view = 'Layout';
    }

    /**
     * method decides to which controller delegate the work
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        $parsedURL = $this->parseURL($params[0]);

        //if no params given
        if(empty($parsedURL[0]))
            $this->redirect('article/uvod');

        //creating instance of controller
        $controllerClass = $this->dashToCamelCase(array_shift($parsedURL)).'Controller';
        if(file_exists('phpContent/controller/'.$controllerClass.'.php')) {
            $controllerClass = 'controller\\'.$controllerClass;
            $this->controller = new $controllerClass;
        }
        else {
            $this->redirect('error');
        }
        $this->controller->process($parsedURL);
        $this->setData();
    }

    /**
     * parses pretty url to array of parameters
     * eg. localhost/article/name-of-article/another-parameter to array( 'name-of-article', 'another-parameter')
     * @param $url
     * @return array
     */
    private function parseURL($url){
        $parsedURL = parse_url($url);
        //cut last / if present
        $parsedURL['path'] = ltrim($parsedURL['path'], '/');
        //cut white marks
        $parsedURL['path'] = trim($parsedURL['path']);

        $splitPath = explode('/', $parsedURL['path']);
        return $splitPath;
    }

    /**
     * parses strings with dashes to camelCase notation
     * eg. name-of-article to nameOfArticle
     * @param $text
     * @return mixed|string
     */
    private function dashToCamelCase($text){
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return $text;
    }

    private function setData(){
        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];
        $this->data['sysMessage'] = $this->getSysMessage();
    }
}