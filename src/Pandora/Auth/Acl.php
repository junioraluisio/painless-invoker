<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 21/05/2017
 * Time: 11:45
 */

namespace Pandora\Auth;

use Pandora\Connection\Conn;
use Pandora\Contracts\Database\iDataManager;

/**
 * Class Acl
 * @package Pandora\Auth
 */
class Acl
{
    /**
     * @var \Pandora\Connection\Conn
     */
    private $conn;
    
    /**
     * @var \Pandora\Contracts\Database\iDataManager
     */
    private $permissions;
    
    /**
     * Acl constructor.
     *
     * @param \Pandora\Connection\Conn                 $conn
     * @param \Pandora\Contracts\Database\iDataManager $permissions
     */
    public function __construct(Conn $conn, iDataManager $permissions)
    {
        $this->setConn($conn);
        $this->setPermissions($permissions);
    }
    
    /**
     * @param int $roleId
     * @param int $resourceId
     * @param int $actionId
     *
     * @return bool
     */
    public function allow(int $roleId, int $resourceId, int $actionId): bool
    {
        $fieldsValues = [
            'role_id'     => $roleId,
            'resource_id' => $resourceId,
            'action_id'   => $actionId
        ];
        
        return $this->permissions->findUnique($fieldsValues);
    }
    
    /**
     * @param \Pandora\Contracts\Database\iDataManager $permissions
     *
     * @return $this
     */
    public function setPermissions(iDataManager $permissions)
    {
        $this->permissions = $permissions;
        
        return $this;
    }
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return $this
     */
    private function setConn(Conn $conn)
    {
        $this->conn = $conn;
        
        return $this;
    }
}