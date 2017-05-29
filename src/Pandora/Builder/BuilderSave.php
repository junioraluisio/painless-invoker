<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 17:52
 */

namespace Pandora\Builder;


/**
 * Class BuilderSave
 * @package Pandora\Builder
 */
class BuilderSave
{
    /**
     * @var string com o caminho principal para armazenamento das classes geradas
     */
    private $pathApp;
    
    /**
     * @var string com o caminho principal para armazenamento dos arquivos de ações gerados
     */
    private $pathApi;
    
    /**
     * BuilderSave constructor.
     *
     * @param string $pathApp
     * @param string $pathApi
     */
    public function __construct($pathApp, $pathApi)
    {
        $this->pathApp = $pathApp;
        $this->pathApi = $pathApi;
    }
    
    /**
     * @param \Pandora\Builder\BuilderClass $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveClass(BuilderClass $builder): BuilderSave
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespace();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderClassInterface $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveClassInterface(BuilderClassInterface $builder): BuilderSave
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespaceInterface();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . 'i' . $name . '.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderClassManager $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveManager(BuilderClassManager $builder): BuilderSave
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespace();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . 'Manager.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderClassManagerInterface $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveManagerInterface(BuilderClassManagerInterface $builder): BuilderSave
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespaceInterface();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . 'i' . $name . 'Manager.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionInsert $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveActionInsert(BuilderActionInsert $builder): BuilderSave
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_insert.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionUpdate $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveActionUpdate(BuilderActionUpdate $builder): BuilderSave
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_update.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionDisable $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveActionDisable(BuilderActionDisable $builder): BuilderSave
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_disable.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionEnable $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveActionEnable(BuilderActionEnable $builder): BuilderSave
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_enable.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param \Pandora\Builder\BuilderHtaccess $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveHtaccess(BuilderHtaccess $builder): BuilderSave
    {
        $text = $builder->write();
        
        $dir = $this->pathApi . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . '.htaccess';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    
    /**
     * @param \Pandora\Builder\BuilderApiIndex $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveApiIndex(BuilderApiIndex $builder): BuilderSave
    {
        $text = $builder->write();
        
        $dir = $this->pathApi . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . 'index.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    /**
     * @param $file
     * @param $text
     */
    private function createSaveFile($file, $text)
    {
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
}
