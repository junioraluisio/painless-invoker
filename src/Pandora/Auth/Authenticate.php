<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 26/05/2017
 * Time: 21:18
 */

namespace Pandora\Auth;


use Entities\Contracts\Auth\Users\iUsersManager;
use Pandora\Contracts\iAuthenticate;

/**
 * Class Authenticate
 * @package Pandora\Auth
 */
class Authenticate implements iAuthenticate
{
    /**
     * @param \Entities\Contracts\Auth\Users\iUsersManager $usersManager
     * @param string                                       $login
     * @param string                                       $password
     *
     * @return bool
     */
    public function login(iUsersManager $usersManager, string $login, string $password): bool
    {
        $arr = ['login' => $login];
        
        $user = $usersManager->findByFieldsValues($arr, 1);
        
        $salt = $user['user_password'];
        
        return password_verify($password, $salt);
    }
}