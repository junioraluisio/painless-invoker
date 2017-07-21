<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/04/2017
 * Time: 09:30
 */

namespace Pandora\Builder;

/**
 * Class BuilderRoutes
 * @package Pandora\Builder
 */
class BuilderRoutes
{
    use BuilderTrait;
    
    function __construct(string $name)
    {
        $this->setTable($name)
             ->setTableName($name)
             ->setNameParameter($name)
             ->setClassName($name);
    }
    
    /**
     * @return string
     */
    public function write(): string
    {
        $write = $this->writeHead();
        $write .= $this->routeInsert();
        $write .= $this->routeUpdate();
        $write .= $this->routeEnable();
        $write .= $this->routeDisable();
        $write .= $this->routeIncludeExtra();
        
        return $write;
    }
    
    public function writeExtra()
    {
        $path = $this->getClassName();
        
        $write = $this->writeHead();
        $write .= $this->line("//Rotas extras :: $path", 0, 0);
        
        return $write;
    }
    
    private function routeDisable()
    {
        $path = $this->getClassName();
        $name = $this->getNameParameter();
        
        $text = $this->line("\$app->delete('/user/{id}', function (Request \$request, Response \$response, \$arguments) {", 0, 1);
        $text .= $this->line("\$conn = \$this->conn;", 4, 2);
        $text .= $this->line("include \$this->config['PATH_ROOT'] . '\api\\" . $path . "\\" . $name . "_disable.php';", 4, 1);
        $text .= $this->line("});", 0, 2);
        
        return $text;
    }
    
    private function routeEnable()
    {
        $path = $this->getClassName();
        $name = $this->getNameParameter();
        
        $text = $this->line("\$app->patch('/user/{id}', function (Request \$request, Response \$response, \$arguments) {", 0, 1);
        $text .= $this->line("\$conn = \$this->conn;", 4, 2);
        $text .= $this->line("include \$this->config['PATH_ROOT'] . '\api\\" . $path . "\\" . $name . "_enable.php';", 4, 1);
        $text .= $this->line("});", 0, 2);
        
        return $text;
    }
    
    private function routeIncludeExtra()
    {
        $text = $this->line("include 'UsersRoutesExtra.php';", 0, 0);
        
        return $text;
    }
    
    private function routeInsert()
    {
        $path = $this->getClassName();
        $name = $this->getNameParameter();
        
        $text = $this->line("\$app->post('/user', function (Request \$request, Response \$response, \$arguments) {", 0, 1);
        $text .= $this->line("\$conn = \$this->conn;", 4, 2);
        $text .= $this->line("include \$this->config['PATH_ROOT'] . '\api\\" . $path . "\\" . $name . "_insert.php';", 4, 1);
        $text .= $this->line("});", 0, 2);
        
        return $text;
    }
    
    private function routeUpdate()
    {
        $path = $this->getClassName();
        $name = $this->getNameParameter();
        
        $text = $this->line("\$app->put('/user/{id}', function (Request \$request, Response \$response, \$arguments) {", 0, 1);
        $text .= $this->line("\$conn = \$this->conn;", 4, 2);
        $text .= $this->line("include \$this->config['PATH_ROOT'] . '\api\\" . $path . "\\" . $name . "_update.php';", 4, 1);
        $text .= $this->line("});", 0, 2);
        
        return $text;
    }
}