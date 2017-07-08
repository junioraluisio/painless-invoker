<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 31/05/2017
 * Time: 15:22
 */

namespace Pandora\Contracts\Database;


interface iDataObject
{
    public function getId();
    
    public function getTable(): string;
    
    public function getPrefix(): string;
}