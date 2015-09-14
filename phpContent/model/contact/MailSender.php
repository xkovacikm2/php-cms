<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 16.7.2015
 * Time: 17:02
 */
namespace model\contact;
use model\exceptions\UserException;

class MailSender {
    private $validator;

    public function __construct(){
        $this->validator = new MailValidator();
    }

    /**
     * redirects to itself & clears post and get
     */
    private function redirect(){
        header('Location: '.$_SERVER['REQUEST_URI']);
        header("Connection: close");
        exit;
    }

    /**
     * Sends the email
     * @param $address
     * @param $sender
     * @param $text
     * @throws UserException
     */
    private function sendEmail($address, $sender, $text){
        $header = "From: $sender";
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        if (!mb_send_mail($address, 'Message from contact form', $text, $header))
            throw new UserException('Email sa nepodarilo odoslať.');
    }

    /**
     * interface operating sending mails
     */
    public function send(){
        if(!isset($_POST['text']))
            return null;
        try {
            $this->validator->validateMessage($_POST['text']);
            $this->validator->validateCaptcha();
            $this->validator->validateEmailAddress($_POST['address']);

            $this->sendEmail("xkovacikm2@gmail.com", $_POST['address'], $_POST['text']);
            return("Mail úspešne odoslaný");
        }
        catch(UserException $e){
            throw $e;
        }
    }

    /**
     * Delegates requests for captcha phrase to captcha generator
     * @return string
     */
    public function getCaptcha(){
        return $this->validator->getCaptcha();
    }
}