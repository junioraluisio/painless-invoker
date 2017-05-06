<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/04/2017
 * Time: 09:30
 */

namespace Invoker\Builder;


class BuilderRoutes
{
    use BuilderTrait;
    
    /**
     * @return string
     */
    public function write(): string
    {
        $write = $this->line("\$app->get('/users/insert', function (\$request, \$response, \$args) {", 0, 1);
        $write .= $this->line("\$conn = \$this->conn;", 4, 2);
        $write .= $this->line("include 'Users/users_insert.php';", 4, 1);
        $write .= $this->line("});", 0, 0);
        
        return $write;
    }
}