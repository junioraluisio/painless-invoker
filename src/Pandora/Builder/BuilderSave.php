<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 17:52
 */

namespace Pandora\Builder;


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
        $this->pathApi  = $pathApi;
    }
    
    /**
     * @param \Pandora\Builder\BuilderClass $builder
     */
    public function saveClass(BuilderClass $builder)
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespace();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderClassManager $builder
     */
    public function saveManager(BuilderClassManager $builder)
    {
        $text      = $builder->write();
        $name      = $builder->getClassName();
        $namespace = $builder->getNamespace();
        
        $dir = $this->pathApp . $namespace . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . 'Manager.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionInsert $builder
     */
    public function saveActionInsert(BuilderActionInsert $builder)
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_insert.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionUpdate $builder
     */
    public function saveActionUpdate(BuilderActionUpdate $builder)
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_update.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionDisable $builder
     */
    public function saveActionDisable(BuilderActionDisable $builder)
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_disable.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderActionEnable $builder
     */
    public function saveActionEnable(BuilderActionEnable $builder)
    {
        $text  = $builder->write();
        $name  = $builder->getNameParameter();
        $class = $builder->getClassName();
        
        $dir = $this->pathApi . $class . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . '_enable.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderHtaccess $builder
     */
    public function saveHtaccess(BuilderHtaccess $builder)
    {
        $text  = $builder->write();
        
        $dir = $this->pathApi . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . '.htaccess';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
    
    /**
     * @param \Pandora\Builder\BuilderApiIndex $builder
     */
    public function saveApiIndex(BuilderApiIndex $builder)
    {
        $text  = $builder->write();
        
        $dir = $this->pathApi . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . 'index.php';
        
        $php = fopen($file, 'w');
        
        fwrite($php, $text);
        fclose($php);
    }
}
