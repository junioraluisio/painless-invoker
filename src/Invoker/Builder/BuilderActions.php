<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/04/2017
 * Time: 18:35
 */

namespace Invoker\Builder;


class BuilderActions
{
    /**
     * Escreve o arquivo
     *
     * @return string
     */
    public function write(): string
    {
        $actions = ['Insert','Update','Enable','Disable'];
    
        foreach ($actions as $action) {
        
        }
        
        return true;
    }
    
}