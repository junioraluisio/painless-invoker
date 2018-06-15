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
     * @param array $parameters
     *
     * @return mixed
     */
    public function disable(array $parameters = []);
    
    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function enable(array $parameters = []);
    
    /**
     * @param array  $parameters
     * @param string $parameter
     * @param string $valueDefault
     * @param string $type
     *
     * @return mixed
     */
    public function extractRequest(array $parameters, string $parameter, string $valueDefault, string $type='normal');
}