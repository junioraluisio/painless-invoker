<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 05/06/2017
 * Time: 08:01
 */

namespace Pandora\Maker;


use Pandora\Builder\BuilderActions;
use Pandora\Builder\BuilderApiIndex;
use Pandora\Builder\BuilderClass;
use Pandora\Builder\BuilderEnv;
use Pandora\Builder\BuilderHtaccess;
use Pandora\Builder\BuilderMiddleware;
use Pandora\Builder\BuilderRoutes;
use Pandora\Builder\BuilderSave;
use Pandora\Database\Database;
use Pandora\Utils\Messages;


class MakerActions
{
    /**
     * @var \Pandora\Database\Database
     */
    private $database;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \Pandora\Builder\BuilderSave
     */
    private $save;
    
    /**
     * MakerActions constructor.
     *
     * @param \Pandora\Builder\BuilderSave $save
     * @param \Pandora\Database\Database   $database
     * @param string                       $name
     */
    public function __construct(BuilderSave $save, Database $database, string $name)
    {
        $this->setDatabase($database);
        $this->setSave($save);
        $this->setName($name);
    }
    
    public function env()
    {
        $builderEnv = new BuilderEnv();
        
        $this->save->saveEnvFile($builderEnv);
        
        Messages::console('Successfully created .env file!', 1, 1);
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function action()
    {
        if (empty($this->database->getTable())) {
            Messages::exception('Set the database table!', 1, 2);
        }
        
        $builderAction = new BuilderActions($this->getDatabase());
        
        $this->save->saveAction($builderAction);
        
        Messages::console('Action created successfully!', 1, 1);
        
        return $this;
    }
    
    public function class()
    {
        if (empty($this->database->getTable())) {
            Messages::exception('Error: Set the database table!', 1, 2);
        }
        
        $builderClass = new BuilderClass($this->getDatabase());
        
        $this->save->saveClass($builderClass);
        
        Messages::console('Class created successfully!', 1, 1);
        
        return $this;
    }
    
    public function help($methods)
    {
        $cmdHelp = 'Usage: ' . PHP_EOL . PHP_EOL;
        $cmdHelp .= 'invoker [options] [] ';
        $cmdHelp .= 'invoker [' . implode(' | ', $methods) . '] ';
        $cmdHelp .= '[empty | -t <table_name> | -n <name>]' . PHP_EOL . PHP_EOL;
        $cmdHelp .= 'Examples: ' . PHP_EOL . PHP_EOL;
        $cmdHelp .= '  # invoker make:actions table:<table_name>' . PHP_EOL;
        $cmdHelp .= '  # invoker make:classes table:<table_name>' . PHP_EOL;
        $cmdHelp .= '  # invoker make:htaccess' . PHP_EOL;
        $cmdHelp .= '  # invoker make:index' . PHP_EOL;
        $cmdHelp .= '  # invoker make:middleware name:<middleware_name>' . PHP_EOL;
        
        return $cmdHelp;
    }
    
    public function htaccess()
    {
        $builderHtaccess = new BuilderHtaccess();
        
        $this->save->saveHtaccess($builderHtaccess);
        
        Messages::console('Successfully created .htaccess file!', 1, 1);
        
        return $this;
    }
    
    public function index()
    {
        $builderApiIndex = new BuilderApiIndex();
        
        $this->save->saveApiIndex($builderApiIndex);
        
        Messages::console('Successfully created index file!', 1, 1);
        
        return $this;
    }
    
    public function middleware()
    {
        if (empty($this->getName())) {
            Messages::exception('Error: Set the middleware name!', 1, 2);
        }
        
        $builderMiddleware = new BuilderMiddleware($this->getName());
        
        $this->save->saveMiddleware($builderMiddleware);
        
        Messages::console('Middleware created successfully!', 1, 1);
        
        return $this;
    }
    
    public function routes()
    {
        if (empty($this->database->getTable())) {
            Messages::exception('Error: Set the database table!', 1, 2);
        }
        
        $builderRoute = new BuilderRoutes($this->database);
        
        $this->save->saveRoutes($builderRoute);
        
        Messages::console('Route created successfully!', 1, 1);
        
        return $this;
    }
    
    /**
     * @return \Pandora\Database\Database
     */
    private function getDatabase(): Database
    {
        return $this->database;
    }
    
    /**
     * @return string
     */
    private function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param \Pandora\Database\Database $database
     *
     * @return MakerActions
     */
    private function setDatabase(Database $database): MakerActions
    {
        $this->database = $database;
        
        return $this;
    }
    
    /**
     * @param string $name
     *
     * @return MakerActions
     */
    private function setName(string $name): MakerActions
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderSave $save
     *
     * @return MakerActions
     */
    private function setSave(BuilderSave $save): MakerActions
    {
        $this->save = $save;
        
        return $this;
    }
}