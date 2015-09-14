<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 16.7.2015
 * Time: 20:39
 */

namespace model\captcha;
include_once ('phpContent/model/captcha/lib/recaptchalib.php');

class MyReCaptcha implements ICaptcha{

    private $key;
    private $response;
    private $reCaptchLib;

    public function __construct(){
        $this->key = '6LcJ7gkTAAAAANKfWPyZfmqkOdJqiGiIScqTalI7';
        $this->reCaptchLib = new \ReCaptcha($this->key);
        $this->response = null;
    }

    public function validateCaptcha(){
        $this->response = $this->reCaptchLib->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
        return $this->response->success;
    }

    public function writeCaptcha(){
        return '<script src="https://www.google.com/recaptcha/api.js"></script>'
        .'<div class="g-recaptcha" data-sitekey="6LcJ7gkTAAAAADESJIvX-IwJJ9cpO1danJsyY84z"></div>';
    }
}