<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 28/05/2017
 * Time: 07:49
 */

namespace Pandora\Contracts\Auth;

use Pandora\Contracts\Database\iDataManager;


/**
 * Class Authenticate
 * @package Pandora\Auth
 */
interface iAuthenticate
{
    /**
     * iAuthenticate constructor.
     *
     * @param \Pandora\Contracts\Database\iDataManager $dm
     * @param string                                   $login
     * @param string                                   $password
     */
    public function __construct(iDataManager $dm, string $login, string $password);
    
    /**
     * @return bool
     */
    public function getin(): array;
}