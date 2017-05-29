<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/04/2017
 * Time: 07:23
 */

namespace Pandora\Builder;

/**
 * Class BuilderHtaccess
 * @package Pandora\Builder
 */
class BuilderHtaccess
{
    use BuilderTrait;
    
    /**
     * @return string
     */
    public function write(): string
    {
        $write = $this->line('RewriteEngine On', 0, 1);
        $write .= $this->line('RewriteCond %{REQUEST_FILENAME} !-f', 0, 1);
        $write .= $this->line('RewriteCond %{REQUEST_FILENAME} !-d', 0, 1);
        $write .= $this->line('RewriteRule ^ index.php [QSA,L]', 0, 2);
        
        $write .= $this->line("<files .env>", 0, 1);
        $write .= $this->line("order allow,deny", 4, 1);
        $write .= $this->line("deny from all", 4, 1);
        $write .= $this->line("</files>", 0, 0);
        
        return $write;
    }
}