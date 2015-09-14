<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 30.6.2015
 * Time: 12:09
 */
namespace model\captcha;

class YearCaptcha implements ICaptcha{

    /**
     * @Override - inherited from ICaptcha
     */
    public function writeCaptcha(){
        return 'Zadajte akt. rok: <input type="text" name="validation"/>';
    }

    /**
     * @Override - inherited from ICaptcha
     */
    public function validateCaptcha(){
        return ( $_POST['validation'] == date("Y"));
    }
}