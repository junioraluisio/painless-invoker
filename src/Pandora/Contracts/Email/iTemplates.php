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
     *
     * @param string $path
     */
    public function __construct(string $path);
    
    /**
     * @param string $template
     *
     * @return mixed
     */
    public function load(string $template);
    
    /**
     * @param array  $itens
     * @param string $text
     *
     * @return mixed
     */
    public function replace(array $itens, string $text);
}