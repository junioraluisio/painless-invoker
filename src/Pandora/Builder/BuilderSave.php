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
     * @var string com o caminho principal para armazenamento dos arquivos de ações gerados
     */
    private $pathApi;
    
    /**
     * @var string com o caminho principal para armazenamento das classes geradas
     */
    private $pathApp;
    
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
     * @param \Pandora\Builder\BuilderActions $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveAction(BuilderActions $builder): BuilderSave
    {
        $text = $builder->write();
        $name = $builder->getClassName();
        
        $dir = $this->pathApp . '/Actions/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . 'Actions.php';
        
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
     * @param \Pandora\Builder\BuilderEnv $builder
     *
     * @return \Pandora\Builder\BuilderSave
     */
    public function saveEnvFile(BuilderEnv $builder): BuilderSave
    {
        $text = $builder->write();
        
        $dir = './';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . '.env';
        
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
    
    public function saveMiddleware(BuilderMiddleware $builder): BuilderSave
    {
        $text = $builder->write();
        $name = ucfirst($builder->getTable());
        
        $dir = $this->pathApp . 'Middlewares/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . 'Middleware.php';
        
        $this->createSaveFile($file, $text);
        
        return $this;
    }
    
    public function saveRoutes(BuilderRoutes $builder): BuilderSave
    {
        $text = $builder->write();
        $name = ucfirst($builder->getClassName());
        
        $dir = $this->pathApp . 'Routes/' . $name . '/';
        
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $file = $dir . $name . 'Routes.php';
        
        $this->createSaveFile($file, $text);
        
        $textExtra = $builder->writeExtra();
        
        $fileExtra = $dir . $name . 'RoutesExtra.php';
        
        if (!file_exists($fileExtra)) {
            $this->createSaveFile($fileExtra, $textExtra);
        }
        
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
