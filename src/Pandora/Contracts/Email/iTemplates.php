<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/06/2018
 * Time: 08:29
 */

namespace Pandora\Contracts\Email;

interface iTemplates
{
    /**
     * iTemplates constructor.
     */
    public function __construct();
    
    /**
     * @param string $template
     *
     * @return mixed
     */
    public function load(string $template);
}