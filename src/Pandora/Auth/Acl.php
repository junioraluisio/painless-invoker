<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 21/05/2017
 * Time: 11:45
 */

namespace Pandora\Auth;

use Entities\Contracts\Auth\Actions\iActions;
use Entities\Contracts\Auth\Permissions\iPermissionsManager;
use Entities\Contracts\Auth\Roles\iRoles;
use Entities\Contracts\Auth\Targets\iTargets;
use Pandora\Connection\Conn;

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
     * Acl constructor.
     *
     * @param \Pandora\Connection\Conn $conn
     */
    public function __construct(Conn $conn)
    {
        $this->setConn($conn);
    }
    
    /**
     * @param \Entities\Contracts\Auth\Roles\iRoles                    $roles
     * @param \Entities\Contracts\Auth\Actions\iActions                $actions
     * @param \Entities\Contracts\Auth\Targets\iTargets                $targets
     * @param \Entities\Contracts\Auth\Permissions\iPermissionsManager $permissionsManager
     *
     * @return bool
     */
    public function allow(iRoles $roles, iActions $actions, iTargets $targets, iPermissionsManager $permissionsManager): bool
    {
        $roleId   = $roles->getId();
        $actionId = $actions->getId();
        $targetId = $targets->getId();
        
        $fieldsValues = [
            'role_id'   => $roleId,
            'action_id' => $actionId,
            'target_id' => $targetId
        ];
        
        $op = $permissionsManager->findByFieldsValues($fieldsValues);
        
        return count($op) > 0 ? true : false;
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