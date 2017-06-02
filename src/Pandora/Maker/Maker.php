<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 29/04/2017
 * Time: 22:14
 */

namespace Pandora\Maker;

use Exception;
use Pandora\Builder\BuilderActionDisable;
use Pandora\Builder\BuilderActionEnable;
use Pandora\Builder\BuilderActionInsert;
use Pandora\Builder\BuilderActionUpdate;
use Pandora\Builder\BuilderApiIndex;
use Pandora\Builder\BuilderClass;
use Pandora\Builder\BuilderClassInterface;
use Pandora\Builder\BuilderClassManager;
use Pandora\Builder\BuilderClassManagerInterface;
use Pandora\Builder\BuilderHtaccess;
use Pandora\Builder\BuilderSave;
use Pandora\Database\Database;
use Pandora\Utils\Messages;

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
     * @param \Pandora\Builder\BuilderSave $save
     * @param \Pandora\Database\Database   $database
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
                Messages::exception('Command: invoker [' . implode(', ', $this->methods) . '] [table_name]', 1, 2);
            } else {
                if (!method_exists($this, $command)) {
                    Messages::exception('Error: The command ' . $command . '() is invalid!', 1, 2);
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
     * @param \Pandora\Builder\BuilderSave $save
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
     * @param \Pandora\Builder\BuilderSave $save
     *
     * @return $this
     */
    private function classes(BuilderSave $save)
    {
        if (empty($this->table)) {
            Messages::exception('Set the database table!', 1, 1);
        }
        
        $builderClass                 = new BuilderClass($this->database);
        //$builderClassInterface        = new BuilderClassInterface($this->database);
        //$builderClassManager          = new BuilderClassManager($this->database);
        //$builderClassManagerInterface = new BuilderClassManagerInterface($this->database);
        
        $save->saveClass($builderClass);
        //$save->saveClassInterface($builderClassInterface);
        //$save->saveManager($builderClassManager);
        //$save->saveManagerInterface($builderClassManagerInterface);
        
        Messages::console('Classe created successfully!', 1, 1);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderSave $save
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
     * @param \Pandora\Builder\BuilderSave $save
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