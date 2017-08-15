<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/08/2017
 * Time: 09:12
 */

namespace Pandora\Contracts\Connection;

use Pandora\Connection\Conn;

/**
 * Class Conn
 * @package Pandora\Connection
 */
interface iConn
{
    /**
     * @param string $driver
     *
     * @return \Pandora\Connection\Conn
     */
    public function setDsn(string $driver): Conn;
    
    /**
     * @param string $password
     *
     * @return \Pandora\Connection\Conn
     */
    public function setPassword(string $password): Conn;
    
    /**
     * @param string $user
     *
     * @return \Pandora\Connection\Conn
     */
    public function setUser(string $user): Conn;
    
    /**
     * @return string
     */
    public function getDb();
    
    /**
     * @param string $db
     *
     * @return \Pandora\Connection\Conn
     */
    public function setDb(string $db): Conn;
    
    /**
     * @return string
     */
    public function getHost();
    
    /**
     * @param string $host
     *
     * @return \Pandora\Connection\Conn
     */
    public function setHost(string $host): Conn;
}