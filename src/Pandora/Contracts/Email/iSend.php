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
     * @param array  $mail
     * @param string $subject
     * @param string $bodyHtml
     * @param string $bodyNoHtml
     *
     * @return mixed
     */
    public function simple(array $mail, string $subject, string $bodyHtml, string $bodyNoHtml);
    
    /**
     * @param string $email Email que será checado
     */
    public function checkMail(string $email);
}