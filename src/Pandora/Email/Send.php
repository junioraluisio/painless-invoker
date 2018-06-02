<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/06/2018
 * Time: 19:14
 */

namespace Pandora\Email;


use Pandora\Contracts\Email\iSend;
use Pandora\Utils\Messages;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Send implements iSend
{
    /**
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private $mail;
    
    /**
     * Send constructor.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $PHPMailer
     */
    public function __construct(PHPMailer $PHPMailer)
    {
        $this->mail = $PHPMailer;
    }
    
    /**
     * @param array  $mail           Array com as informações do email que receberá a mensagem $mail['box'], $mail['name']
     * @param string $subject        Assunto do email
     * @param string $bodyHtml       Texto do email em HTML
     * @param string $bodyNoHtml     Texto do email sem tags HTML
     * @param string $messageSuccess Mensagem de retorno em caso de sucesso
     *
     * @return string
     */
    public function simple(array $mail, string $subject, string $bodyHtml, string $bodyNoHtml, string $messageSuccess)
    {
        $this->checkMail($mail['box']);
        
        try {
            //Server settings
            $this->mail->SMTPDebug = 2;
            $this->mail->isSMTP();
            $this->mail->Host       = $_ENV['MAIL_SMTP_HOST'];
            $this->mail->SMTPAuth   = $_ENV['MAIL_SMTP_AUTH'];
            $this->mail->Username   = $_ENV['MAIL_SMTP_USER'];
            $this->mail->Password   = $_ENV['MAIL_SMTP_PASSWORD'];
            $this->mail->SMTPSecure = $_ENV['MAIL_SMTP_SECURE'];
            $this->mail->Port       = $_ENV['MAIL_SMTP_PORT'];
            
            //Recipients
            $this->mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            $this->mail->addAddress($mail['box'], $mail['name']);
            
            //Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $bodyHtml;
            $this->mail->AltBody = $bodyNoHtml;
            
            $this->mail->send();
            
            return $messageSuccess;
        } catch (Exception $e) {
            return 'O e-mail não pode ser enviado. Error: ' . $this->mail->ErrorInfo;
        }
    }
    
    /**
     * @param string $email Email que será checado
     */
    public function checkMail(string $email)
    {
        if (empty($email)) {
            Messages::exception('Digite uma senha!');
        }
    }
}