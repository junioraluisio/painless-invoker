<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 30/05/2017
 * Time: 10:05
*/

namespace Pandora\Contracts\Auth\Users;


interface iUsers
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
     * @param string $name . [max-length: 200]
     */
    public function setName($name);

    /**
     * return string
     */
    public function getName();

    /**
     * @param string $flag Flag do usuário. [max-length: 200]
     */
    public function setFlag($flag);

    /**
     * return string
     */
    public function getFlag();

    /**
     * @param string $email . [max-length: 200]
     */
    public function setEmail($email);

    /**
     * return string
     */
    public function getEmail();

    /**
     * @param string $login . [max-length: 200]
     */
    public function setLogin($login);

    /**
     * return string
     */
    public function getLogin();

    /**
     * @param string $password Senha do usuário. [max-length: 200]
     */
    public function setPassword($password);

    /**
     * return string
     */
    public function getPassword();

    /**
     * @param string $condition . [max-length: 1]
     */
    public function setCondition($condition);

    /**
     * return string
     */
    public function getCondition();

}