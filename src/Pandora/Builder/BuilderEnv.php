<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2018
 * Time: 14:36
 */

namespace Pandora\Builder;


use Pandora\Utils\Str;

class BuilderEnv
{
    use BuilderTrait;
    
    /**
     * @return string
     */
    public function write(): string
    {
        $write = $this->writeSystem();
        $write .= $this->writeDatabase();
        $write .= $this->writeMail();
        $write .= $this->writeTemplatesFolders();
        $write .= $this->writeTokenInformation();
        $write .= $this->writePathsAuth();
        
        return $write;
    }
    
    private function writeDatabase()
    {
        $text = $this->line("# Database", 0, 1);
        $text .= $this->line("DB_CONNECTION=mysql", 0, 1);
        $text .= $this->line("DB_HOST=127.0.0.1", 0, 1);
        $text .= $this->line("DB_PORT=3306", 0, 1);
        $text .= $this->line("DB_NAME=", 0, 1);
        $text .= $this->line("DB_USER=", 0, 1);
        $text .= $this->line("DB_PASS=", 0, 2);
        
        return $text;
    }
    
    private function writeTemplatesFolders()
    {
        $text = $this->line("# Templates folders", 0, 1);
        $text .= $this->line("VIEW_PATH=public/views", 0, 1);
        $text .= $this->line("VIEW_CACHE=tmp/cache/views", 0, 2);
        
        return $text;
    }
    
    private function writeTokenInformation()
    {
        $objStr = new Str();
        
        $jwtId = $objStr->generatePassword(16);
        
        $jwtSecret = $objStr->generatePassword(96);
        
        $text = $this->line("# Token information", 0, 1);
        $text .= $this->line("JWT_ISSUER=", 0, 1);
        $text .= $this->line("JWT_AUDIENCE=", 0, 1);
        $text .= $this->line("JWT_ID=$jwtId", 0, 1);
        $text .= $this->line("JWT_SECRET=$jwtSecret", 0, 1);
        $text .= $this->line("JWT_PATH_PROTECTED=/api|/app", 0, 2);
        $text .= $this->line("JWT_PATH_PASSTHROUGH=/auth", 0, 0);
        
        return $text;
    }
    
    private function writePathsAuth()
    {
        $text = $this->line("# Paths Auth", 0, 1);
        $text .= $this->line("PATH_PROTECTED=/api|/app", 0, 1);
        $text .= $this->line("PATH_PASSTHROUGH=/auth", 0, 2);
        
        return $text;
    }
    
    private function writeMail()
    {
        $text = $this->line("# Configuration Mail", 0, 1);
        $text .= $this->line("MAIL_DEBUG=0", 0, 1);
        $text .= $this->line("MAIL_MAILER=sendmail", 0, 1);
        $text .= $this->line("MAIL_SMTP_HOST=smtp.smtp1.domain.com;smtp2.domain.com", 0, 1);
        $text .= $this->line("MAIL_SMTP_AUTH=true", 0, 1);
        $text .= $this->line("MAIL_SMTP_USER=painless@domain.com", 0, 1);
        $text .= $this->line("MAIL_SMTP_PASSWORD=password", 0, 1);
        $text .= $this->line("MAIL_SMTP_SECURE=tls", 0, 1);
        $text .= $this->line("MAIL_SMTP_PORT=587", 0, 1);
        $text .= $this->line("MAIL_FROM=painless@domain.com", 0, 1);
        $text .= $this->line("MAIL_TEMPLATE_PATH=/public/templates/mail", 0, 1);
        $text .= $this->line("MAIL_FROM_NAME=Painless", 0, 2);
        
        return $text;
    }
    
    private function writeSystem()
    {
        $objStr = new Str();
        
        $session = $objStr->generatePassword(16);
        
        $text = $this->line("# System", 0, 1);
        $text .= $this->line("APP_NAME=Painless", 0, 1);
        $text .= $this->line("SESSION_NAME=$session", 0, 2);
        
        return $text;
    }
}