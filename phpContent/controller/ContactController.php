<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 16.7.2015
 * Time: 16:20
 */
namespace controller;
use model\contact\MailSender;
use model\exceptions\UserException;

class ContactController extends Controller{
    private $mailSender;

    public function __construct(){
        $this->view = 'Contact';
        $this->header = array(
            title => 'Kontakt',
            description => 'kontaktný formulár na spojenie so mnou cez contact',
            keywords => 'kontakt, formulár, spojenie, email'
        );
        $this->mailSender = new MailSender();
    }

    /**
     * this is where magic happens
     * @param $params to be processed
     * @return mixed
     */
    public function process($params){
        try{
            $message = $this->mailSender->send();
            if($message!=null) {
                $this->addSysMessage($message);
                $this->redirect('contact');
            }
        }
        catch(UserException $e){
            $this->addSysMessage('Ups: '.$e->getMessage());
        }
    }

    /**
     * Requests captcha from mailSender
     * @return string
     */
    public function getCaptcha(){
        return $this->mailSender->getCaptcha();
    }
}