<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 29/04/2017
 * Time: 22:14
 */

namespace Pandora\Maker;

use Exception;
use Pandora\Utils\Messages;

class Maker
{
    /**
     * @var \Pandora\Maker\MakerActions
     */
    private $actions;
    
    /**
     * @var string
     */
    private $command;
    
    /**
     * @var array
     */
    private $methods = ['actions', 'classes', 'htaccess', 'index', 'middleware'];
    
    /**
     * Maker constructor.
     *
     * @param \Pandora\Maker\MakerActions $actions
     * @param string                      $command
     */
    public function __construct(MakerActions $actions, string $command)
    {
        $this->setActions($actions);
        $this->setCommand($command);
    }
    
    /**
     * @return $this
     */
    public function execute()
    {
        try {
            if ($this->getCommand() == 'help') {
                Messages::exception($this->actions->help($this->methods), 1, 2);
            } else {
                if (!method_exists($this->actions, $this->getCommand())) {
                    Messages::exception('Error: The command ' . $this->getCommand() . '() is invalid!', 1, 2);
                } else {
                    $this->actions->{$this->getCommand()}();
                }
            }
        } catch (Exception $e) {
            Messages::exception($e->getMessage(), 1, 1);
        }
        
        return $this;
    }
    
    /**
     * @return string
     */
    private function getCommand(): string
    {
        return $this->command;
    }
    
    /**
     * @param \Pandora\Maker\MakerActions $actions
     *
     * @return Maker
     */
    private function setActions(MakerActions $actions): Maker
    {
        $this->actions = $actions;
        
        return $this;
    }
    
    /**
     * @param string $command
     */
    private function setCommand(string $command)
    {
        $this->command = $command;
    }
    
    
}