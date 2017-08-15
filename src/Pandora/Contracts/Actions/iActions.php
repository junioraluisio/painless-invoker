<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/08/2017
 * Time: 16:51
 */

namespace Pandora\Contracts\Actions;

interface iActions
{
    /**
     *
     * @return string
     */
    public function insert();
    
    /**
     *
     * @return string
     */
    public function update();
    
    /**
     *
     * @return string
     */
    public function disable();
    
    /**
     *
     * @return string
     */
    public function enable();
}