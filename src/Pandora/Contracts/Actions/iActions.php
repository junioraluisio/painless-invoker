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
     * @param array $parameters
     *
     * @return mixed
     */
    public function insert(array $parameters = []);
    
    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function update(array $parameters = []);
    
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