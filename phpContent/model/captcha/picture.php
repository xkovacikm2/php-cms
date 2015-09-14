<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 11.7.2015
 * Time: 14:02
 */
session_start();
require_once('Classes/ICaptcha.php');
require_once('Classes/ImageCaptcha.php');

$captcha = new ImageCaptcha();
$captcha->generatePicture();