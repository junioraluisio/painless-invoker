<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 26/05/2017
 * Time: 21:18
 */

namespace Pandora\Auth;

use Pandora\Contracts\Auth\iAuthenticate;
use Pandora\Contracts\Database\iDataManager;
use Pandora\Utils\Messages;

/**
 * Class Authenticate
 * @package Pandora\Auth
 */
class Authenticate implements iAuthenticate
{
    /**
     * @var \Pandora\Contracts\Database\iDataManager
     */
    private $dm;
    
    /**
     * @var string
     */
    private $login;
    
    /**
     * @var string
     */
    private $password;
    
    public function __construct(iDataManager $dm, string $login, string $password)
    {
        $this->setDm($dm);
        $this->setLogin($login);
        $this->setPassword($password);
    }
    
    public function getin(): array
    {
        $this->checkLogin();
        $this->checkPassword();
        
        $arr = ['login' => $this->login];
        
        $user = $this->dm->findByFieldsValues($arr, 1);
        
        $salt = $user['user_password'] ?? '';
        
        $ret['id']        = $user['user_id'] ?? '';
        $ret['role_id']   = $user['user_role_id'] ?? '';
        $ret['name']      = $user['user_name'] ?? '';
        $ret['flag']      = $user['user_flag'] ?? '';
        $ret['email']     = $user['user_email'] ?? '';
        $ret['token']     = $user['user_token'] ?? '';
        $ret['condition'] = $user['user_condition'] ?? '';
        $ret['verify']    = password_verify($this->password, $salt);
        
        return $ret;
    }
    
    private function checkLogin()
    {
        if (empty($this->login)) {
            Messages::exception('Digite um login!');
        }
    }
    
    private function checkPassword()
    {
        if (empty($this->password)) {
            Messages::exception('Digite uma senha!');
        }
    }
    
    private function setDm($dm)
    {
        $this->dm = $dm;
        
        return $this;
    }
    
    private function setLogin($login)
    {
        $this->login = $login;
        
        return $this;
    }
    
    private function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
}