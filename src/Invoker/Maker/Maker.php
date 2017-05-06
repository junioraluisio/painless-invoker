<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 29/04/2017
 * Time: 22:14
 */

namespace Invoker\Maker;

use Exception;
use Invoker\Builder\BuilderActionDisable;
use Invoker\Builder\BuilderActionEnable;
use Invoker\Builder\BuilderActionInsert;
use Invoker\Builder\BuilderActionUpdate;
use Invoker\Builder\BuilderApiIndex;
use Invoker\Builder\BuilderClass;
use Invoker\Builder\BuilderClassManager;
use Invoker\Builder\BuilderHtaccess;
use Invoker\Builder\BuilderSave;
use Invoker\Database\Database;
use Invoker\Utils\Messages;

class Maker
{
    private $command;
    private $table;
    private $database;
    private $save;
    private $methods = ['actions', 'classes', 'htaccess', 'index'];
    
    /**
     * Maker constructor.
     *
     * @param \Invoker\Builder\BuilderSave $save
     * @param \Invoker\Database\Database   $database
     * @param string                       $table
     */
    public function __construct(BuilderSave $save, Database $database, string $table)
    {
        $this->database = $database;
        $this->save     = $save;
        $this->table    = $table;
    }
    
    /**
     * @param String $command
     *
     * @return $this
     */
    public function execute(String $command)
    {
        $this->command = $command;
        
        try {
            if (in_array($command, ['-h', '--help'])) {
                Messages::exception('Command: builder [' . implode(', ', $this->methods) . '] [table_name]', 1, 1);
            } else {
                if (!method_exists($this, $command)) {
                    Messages::exception('The command ' . $command . '() is invalid!', 1, 1);
                } else {
                    $this->{$command}($this->save);
                }
            }
        } catch (Exception $e) {
            Messages::exception($e->getMessage(), 1, 1);
        }
        
        return $this;
    }
    
    /**
     * @param \Invoker\Builder\BuilderSave $save
     *
     * @return string
     */
    private function actions(BuilderSave $save)
    {
        if (empty($this->table)) {
            Messages::exception('Set the database table!', 1, 1);
        }
        
        $builderActionInsert  = new BuilderActionInsert($this->database);
        $builderActionUpdate  = new BuilderActionUpdate($this->database);
        $builderActionDisable = new BuilderActionDisable($this->database);
        $builderActionEnable  = new BuilderActionEnable($this->database);
        
        $save->saveActionInsert($builderActionInsert);
        $save->saveActionUpdate($builderActionUpdate);
        $save->saveActionDisable($builderActionDisable);
        $save->saveActionEnable($builderActionEnable);
        
        Messages::console('Actions created successfully!', 1, 1);
        
        return $this;
    }
    
    /**
     * @param \Invoker\Builder\BuilderSave $save
     *
     * @return string
     * @throws \Exception
     */
    private function classes(BuilderSave $save)
    {
        if (empty($this->table)) {
            Messages::exception('Set the database table!', 1, 1);
        }
        
        $builderClass        = new BuilderClass($this->database);
        $builderClassManager = new BuilderClassManager($this->database);
        
        $save->saveClass($builderClass);
        $save->saveManager($builderClassManager);
        
        Messages::console('Classes created successfully!', 1, 1);
        
        return $this;
    }
    
    /**
     * @param \Invoker\Builder\BuilderSave $save
     *
     * @return string
     */
    private function htaccess(BuilderSave $save)
    {
        $builderHtaccess = new BuilderHtaccess();
        
        $save->saveHtaccess($builderHtaccess);
        
        Messages::console('Successfully created .htaccess file!', 1, 1);
        
        return $this;
    }
    
    /**
     * @param \Invoker\Builder\BuilderSave $save
     *
     * @return string
     */
    private function index(BuilderSave $save)
    {
        $builderApiIndex = new BuilderApiIndex();
        
        $save->saveApiIndex($builderApiIndex);
        
        Messages::console('Successfully created index file!', 1, 1);
        
        return $this;
    }
}