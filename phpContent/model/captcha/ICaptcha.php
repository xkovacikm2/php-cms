<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 11.7.2015
 * Time: 14:38
 */
namespace model\captcha;

interface ICaptcha {
    public function validateCaptcha();
    public function writeCaptcha();
}