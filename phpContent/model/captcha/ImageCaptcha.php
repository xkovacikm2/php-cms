<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 11.7.2015
 * Time: 13:47
 */
namespace model\captcha;

class ImageCaptcha implements ICaptcha{

    public function writeCaptcha(){
        return 'Prepíšte text z obrázku: '
        .'<img src="captcha/'.time().'"/>'
        .'<input type="text" name="validation"/>';
    }

    public function validateCaptcha(){
        return (isset($_POST['validation']) && $_POST['validation']==$_SESSION['captcha']);
    }

    public function generatePicture(){
        $sirka = 100;
        $vyska = 20;
        $obrazek = imagecreate($sirka, $vyska);
        $bila = imagecolorallocate($obrazek, 255, 255, 255);
        $modra = imagecolorallocate($obrazek, 0, 0, 255);
        imagefilledrectangle($obrazek, 0, 0, $sirka, $vyska, $bila);

        $znaky = 'abcdefghijklmnopqrstuvwxyz';
        $znaku = mb_strlen($znaky);
        $text = '';

        for ($i = 0; $i < 4; $i++) {
            $pismeno = $znaky[rand(0, $znaku - 1)];
            $text .= $pismeno;
            imagestring($obrazek, 10, 10 + $i * 20, 4, $pismeno, $modra);
        }

        $_SESSION['captcha'] = $text;
        imagejpeg($obrazek);
    }
}