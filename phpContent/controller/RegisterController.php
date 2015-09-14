<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 28.7.2015
 * Time: 11:07
 */

namespace controller;


use model\exceptions\UserException;
use model\user\UserManager;

class RegisterController extends Controller{

    private $userManager;

    public function __construct(){
        $this->userManager = new UserManager();
        $this->header['title'] = 'Registrácia';
        $this->view = 'Registration';
    }
    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        if($_POST){
            try{
                $this->userManager->register($_POST['name'], $_POST['password'], $_POST['password_control']);
                $this->userManager->login($_POST['name'], $_POST['password']);
                $this->addSysMessage('Boli ste úspešne zaregistrovaní');
                $this->redirect('administration');
            }
            catch (UserException $e){
                $this->addSysMessage($e->getMessage());
            }
        }
    }

    /**
     * Delegates getCaptcha to UserManager and returns result
     */
    public function getCaptcha(){
        return $this->userManager->getCaptcha();
    }
}