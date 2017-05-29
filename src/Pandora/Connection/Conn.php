<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 11:10
 */

namespace Pandora\Connection;

use Pandora\Utils\Messages;


/**
 * Class Conn
 * @package Pandora\Connection
 */
class Conn extends \PDO
{
    /**
     * @var null|\PDO
     */
    public  $handle = null;
    
    /**
     * @var string
     */
    private $db;
    
    /**
     * @var string
     */
    private $dsn;
    
    /**
     * @var string
     */
    private $host;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var string
     */
    private $user;
    
    /**
     * Conn constructor.
     *
     * @param string $db
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $driver
     */
    function __construct(string $db, string $host, string $user, string $password, string $driver='MySQL')
    {
        $this->setDb($db);
        $this->setHost($host);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setDsn($driver);
        
        $ret = false;
        
        try {
            if ($this->handle == null) {
                $dbh = parent::__construct($this->dsn, $this->user, $this->password);
                
                $this->handle = $dbh;
                
                $ret = $this->handle;
            }
        } catch (\PDOException $e) {
            Messages::exception('Connection failed: ' . $e->getMessage(), 0, 0);
        }
        
        return $ret;
    }
    
    /**
     * @param string $driver
     *
     * @return \Pandora\Connection\Conn
     */
    public function setDsn(string $driver): Conn
    {
        switch ($driver) {
            case 'MySQL':
                $this->dsn = 'mysql:dbname=' . $this->db . ';host=' . $this->host;
                break;
            default:
                $this->dsn = null;
        }
        
        return $this;
    }
    
    /**
     * @param string $password
     *
     * @return \Pandora\Connection\Conn
     */
    public function setPassword(string $password): Conn
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @param string $user
     *
     * @return \Pandora\Connection\Conn
     */
    public function setUser(string $user): Conn
    {
        $this->user = $user;
        
        return $this;
    }
    
    function __destruct()
    {
        $this->handle = null;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }
    
    /**
     * @param string $db
     *
     * @return \Pandora\Connection\Conn
     */
    public function setDb(string $db): Conn
    {
        $this->db = $db;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * @param string $host
     *
     * @return \Pandora\Connection\Conn
     */
    public function setHost(string $host): Conn
    {
        $this->host = $host;
        
        return $this;
    }
}