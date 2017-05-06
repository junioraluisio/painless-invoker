<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 11:10
 */

namespace Invoker\Connection;

use Invoker\Utils\Messages;

class Conn extends \PDO
{
    public  $handle = null;
    private $db;
    private $dsn;
    private $host;
    private $password;
    private $user;
    
    function __construct($db, $host, $user, $password)
    {
        $this->setDb($db);
        $this->setHost($host);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setDsn();
        
        try {
            if ($this->handle == null) {
                $dbh = parent::__construct($this->dsn, $this->user, $this->password);
                
                $this->handle = $dbh;
                
                return $this->handle;
            }
        } catch (\PDOException $e) {
            Messages::exception('Connection failed: ' . $e->getMessage(),0,0);
            
            return false;
        }
    }
    
    public function setDsn()
    {
        $this->dsn = 'mysql:dbname=' . $this->db . ';host=' . $this->host;
    }
    
    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    function __destruct()
    {
        $this->handle = null;
    }
    
    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }
    
    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }
    
    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }
}