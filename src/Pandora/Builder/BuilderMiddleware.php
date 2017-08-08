<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 05/06/2017
 * Time: 08:56
 */

namespace Pandora\Builder;


class BuilderMiddleware
{
    use BuilderTrait;
    
    /**
     * BuilderMiddleware constructor.
     *
     * @param string $name
     */
    function __construct(string $name)
    {
            $this->setTable($name)
                 ->setTableName($name)
                 ->setNameParameter($name)
                 ->setClassName($name);
    }
    
    /**
     * Escreve a classe
     *
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeNamespace();
        $this->writeStartClass();
        $this->writeBody();
        $this->writeFoot();
        
        return $this->write;
    }
    
    public function writeBody(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param \Psr\Http\Message\ServerRequestInterface \$request", 5, 1);
        $text .= $this->line("* @param \Psr\Http\Message\ResponseInterface      \$response", 5, 1);
        $text .= $this->line("* @param callable                                 \$next", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return \Psr\Http\Message\ResponseInterface", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function __invoke(ServerRequestInterface \$request, ResponseInterface \$response, callable \$next)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("//\$request = \$request->withAttribute('attr', 'Atributo passado via middleware');", 8, 2);
        $text .= $this->line("//\$response->getBody()->write('Texto enviado a view')", 8, 2);
        $text .= $this->line("return \$response;", 8, 1);
        $text .= $this->line("}", 4, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o namespace da classe
     *
     * @return string
     */
    private function writeNamespace(): string
    {
        $text = "";
        
        $text .= $this->line("namespace App\Middlewares;", 0, 3);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o início da classe
     *
     * @return string
     */
    private function writeStartClass(): string
    {
        $text = "";
        
        $stringClass = "class " . ucfirst($this->getTable()) . "Middleware";
        
        $text .= $this->line("use Psr\Http\Message\ResponseInterface;", 0, 1);
        $text .= $this->line("use Psr\Http\Message\ServerRequestInterface;", 0, 3);
        
        $text .= $this->line($stringClass, 0, 1);
        $text .= $this->line("{", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
}