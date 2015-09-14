<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 11.7.2015
 * Time: 14:37
 */
namespace model\contact;
use model\captcha\MyReCaptcha;
use model\exceptions\UserException;

class MailValidator{

    private $captcha;

    public function __construct(){
        $this->captcha = new MyReCaptcha();
    }

    /**
     * @param $emailAddr
     * @throws UserException
     */
    public function validateEmailAddress($emailAddr){
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/u", $emailAddr)){
            throw new UserException("Zlý email");
        }
    }

    /**
     * @throws UserException
     */
    public function validateCaptcha(){
        if ($this->captcha->validateCaptcha() == false){
            throw new UserException("Zlé captcha");
        }
    }

    /**
     * @param $message
     * @throws UserException
     */
    public function validateMessage($message){
        if (!$message){
            throw new UserException("Prázdna správa");
        }
    }

    public function getCaptcha(){
        return $this->captcha->writeCaptcha();
    }
}