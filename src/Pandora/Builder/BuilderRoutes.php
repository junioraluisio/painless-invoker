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
    
    /**
     * @return string
     */
    public function write(): string
    {
        $write = $this->writeHead();
        $write .= $this->writeUses();
        $write .= $this->writeContainer();
        $write .= $this->writeRoutes();
        $write .= $this->writeRouteIncludeExtra();
        
        return $write;
    }
    
    public function writeExtra()
    {
        $path = $this->getClassName();
        
        $write = $this->writeHead();
        $write .= $this->line("//Rotas extras :: $path", 0, 0);
        
        return $write;
    }
    
    private function writeRouteIncludeExtra()
    {
        $obj = $this->getClassName();
        
        $text = $this->line("//Rotas extras", 0, 1);
        $text .= $this->line("include '" . $obj . "RoutesExtra.php';", 0, 0);
        
        return $text;
    }
    
    private function writeContainer()
    {
        $obj = $this->getClassName();
        $objVar = $this->getNameParameter();
        $objNickName = $this->getNickParameter();
        
        $text = "";
        
        $text .= $this->line("\$container['dm" . ucfirst($objNickName) . "'] = function (\$c) {", 0, 1);
        $text .= $this->line("\$$objVar = new " . $obj . "();", 4, 2);
        $text .= $this->line("return new DataManager(\$c['conn'], \$$objVar);", 4, 1);
        $text .= $this->line("};", 0, 2);
        
        return $text;
    }
    
    private function writeRoutes()
    {
        $obj = $this->getClassName();
        $objVar = $this->getNameParameter();
        $nickParameter = $this->getNickParameter();
        
        $actionClass = '\\App\\Actions\\' . $obj . 'Actions::class';
        
        $text = $this->line("\$app->group('/" . str_replace('_', '/', $nickParameter) . "', function () {", 0, 1);
        $text .= $this->line("\$this->map(['PATCH'], '/{id}', $actionClass . ':enable');", 4, 1);
        $text .= $this->line("\$this->map(['DELETE'], '/{id}', $actionClass . ':disable');", 4, 1);
        $text .= $this->line("\$this->map(['PUT'], '/{id}', $actionClass . ':update');", 4, 1);
        $text .= $this->line("\$this->map(['POST'], '', $actionClass . ':insert');", 4, 1);
        $text .= $this->line("});", 0, 2);
        
        return $text;
    }
    
    
    
    /**
     * @return string
     */
    private function writeUses(): string
    {
        $text = $this->line("use Pandora\\Database\\DataManager;", 0, 1);
        
        $nms  = 'App\\' . $this->getNamespace() . '\\' . $this->getClassName();
        $text .= $this->line("use " . $nms . ";", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
}