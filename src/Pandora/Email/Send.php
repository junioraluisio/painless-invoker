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
use Pandora\Validation\Validation;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Send implements iSend
{
    /**
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private $mail;
    
    /**
     * @var
     */
    private $validation;
    
    /**
     * Send constructor.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $PHPMailer
     * @param \Pandora\Validation\Validation $validation
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function __construct(PHPMailer $PHPMailer, Validation $validation)
    {
        $this->mail       = $PHPMailer;
        $this->validation = $validation;
        
        $this->setup();
    }
    
    /**
     * @param array  $mail
     * @param string $subject
     * @param string $bodyHtml
     * @param string $bodyNoHtml
     *
     * @return array|mixed
     */
    public function simple(array $mail, string $subject, string $bodyHtml, string $bodyNoHtml)
    {
        $this->checkMail($mail['box']);
        
        try {
            //Recipients
            $this->mail->addAddress($mail['box'], $mail['name']);
            
            //Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $bodyHtml;
            $this->mail->AltBody = $bodyNoHtml;
            
            $this->mail->send();
            
            return [true, 'Email enviado com sucesso!'];
        } catch (Exception $e) {
            return [false, 'O e-mail não pode ser enviado. Error: ' . $this->mail->ErrorInfo];
        }
    }
    
    /**
     * @param string $email Email que será checado
     */
    public function checkMail(string $email)
    {
        if (empty($email)) {
            Messages::exception('Digite um email!');
        }
        
        if (!$this->validation->isEmail($email)) {
            Messages::exception('Formato de email inválido!');
        }
    }
    
    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function setup()
    {
        //Server settings
        $this->mail->SMTPDebug = $_ENV['MAIL_DEBUG'];
        
        switch ($_ENV['MAIL_MAILER']) {
            case 'sendmail':
                $this->mail->isSendmail();
                break;
            case 'mail':
                $this->mail->isMail();
                break;
            case 'qmail':
                $this->mail->isQmail();
                break;
            default:
                $this->mail->isSMTP();
        }
        
        $this->mail->Host       = $_ENV['MAIL_SMTP_HOST'];
        $this->mail->SMTPAuth   = $_ENV['MAIL_SMTP_AUTH'];
        $this->mail->Username   = $_ENV['MAIL_SMTP_USER'];
        $this->mail->Password   = $_ENV['MAIL_SMTP_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['MAIL_SMTP_SECURE'];
        $this->mail->Port       = $_ENV['MAIL_SMTP_PORT'];
        
        //Recipients
        $this->mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
    }
}