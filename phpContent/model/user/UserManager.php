<?php
/**
 * Created by PhpStorm.
 * User: kovko
 * Date: 25.7.2015
 * Time: 18:21
 */

namespace model\user;


use model\captcha\MyReCaptcha;
use model\database\DBHelper;
use model\exceptions\UserException;

class UserManager{

    private $salt;
    private $captcha;

    public function __construct(){
        $this->salt = ')!@(#*$&%^%{}|":?><';
        $this->captcha = new MyReCaptcha();
    }

    /**
     * Delegates call to captcha and returns result
     * @return string
     */
    public function getCaptcha(){
        return $this->captcha->writeCaptcha();
    }

    /**
     * Creates password print as stored in db from password
     * @param $password
     * @return string
     */
    private function getPassPrint($password){
        return hash('sha256', $password.$this->salt);
    }

    /**
     * Saves user's information to db
     * @param $name
     * @param $password
     * @param $passwordControl
     * @throws UserException
     */
    public function register($name=null, $password, $passwordControl){
        if($this->captcha->validateCaptcha() == false){
            throw new UserException('Zlé captcha');
        }
        if($password !== $passwordControl){
            throw new UserException('Heslá sa nezhodujú');
        }
        if($name === null){
            throw new UserException('Nezadané žiadne meno');
        }
        $user = array(
            user_name => $name,
            user_password => $this->getPassPrint($password)
        );
        try{
            DBHelper::insert('mvc_users',$user);
        }
        catch (\PDOException $e){
            throw new UserException('Uživateľ s daným menom už existuje');
        }
    }

    /**
     * Saves current user data to session
     * @param $name
     * @param $password
     * @throws UserException
     */
    public function login($name, $password){
        $user = DBHelper::fetchOne('
        SELECT user_id, user_name, user_admin
        FROM mvc_users
        WHERE user_name = ? AND user_password = ?
        ', array($name, $this->getPassPrint($password)));

        if(!$user){
            throw new UserException('Zlé meno, alebo heslo');
        }

        $_SESSION['user'] = $user;
    }

    /**
     * unsets user from session
     */
    public function logout(){
        unset($_SESSION['user']);
    }

    /**
     * returns array of user data if logged in or null
     * @return array|null
     */
    public function getUser(){
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
}