<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 30/05/2017
 * Time: 10:05
*/

namespace Pandora\Contracts\Auth\Permissions;


interface iPermissions
{
    /**
     * @param integer $id . [max-length: 10,0]
     */
    public function setId($id);

    /**
     * return integer
     */
    public function getId();

    /**
     * @param integer $role_id . [max-length: 10,0]
     */
    public function setRole_id($role_id);

    /**
     * return integer
     */
    public function getRole_id();

    /**
     * @param integer $action_id . [max-length: 10,0]
     */
    public function setAction_id($action_id);

    /**
     * return integer
     */
    public function getAction_id();

    /**
     * @param integer $target_id . [max-length: 10,0]
     */
    public function setTarget_id($target_id);

    /**
     * return integer
     */
    public function getTarget_id();

    /**
     * @param string $condition . [max-length: 1]
     */
    public function setCondition($condition);

    /**
     * return string
     */
    public function getCondition();

}