<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 28/05/2017
 * Time: 07:49
 */

namespace Pandora\Contracts;

use Entities\Contracts\Auth\Users\iUsersManager;


/**
 * Class Authenticate
 * @package Pandora\Auth
 */
interface iAuthenticate
{
    /**
     * @param \Entities\Contracts\Auth\Users\iUsersManager $usersManager
     * @param string                                       $login
     * @param string                                       $password
     *
     * @return bool
     */
    public function login(iUsersManager $usersManager, string $login, string $password): bool;
}