<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 30/05/2017
 * Time: 10:05
*/

namespace Pandora\Contracts\Auth\Actions;


interface iActions
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
     * @param string $name . [max-length: 200]
     */
    public function setName($name);

    /**
     * return string
     */
    public function getName();

    /**
     * @param string $flag . [max-length: 200]
     */
    public function setFlag($flag);

    /**
     * return string
     */
    public function getFlag();

    /**
     * @param string $condition . [max-length: 1]
     */
    public function setCondition($condition);

    /**
     * return string
     */
    public function getCondition();

}