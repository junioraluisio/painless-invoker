<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/06/2018
 * Time: 19:53
 */

namespace Pandora\Contracts\Email;

interface iSend
{
    /**
     * @param array  $mail           Array com as informações do email que receberá a mensagem $mail['box'], $mail['name']
     * @param string $subject        Assunto do email
     * @param string $bodyHtml       Texto do email em HTML
     * @param string $bodyNoHtml     Texto do email sem tags HTML
     * @param string $messageSuccess Mensagem de retorno em caso de sucesso
     *
     * @return string
     */
    public function simple(array $mail, string $subject, string $bodyHtml, string $bodyNoHtml, string $messageSuccess);
    
    /**
     * @param string $email Email que será checado
     */
    public function checkMail(string $email);
}