<?php
namespace App\Utils;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class EmailProcess
{
    private $mail;

    public function __construct(){
        $config = Dotenv::createImmutable(__DIR__.'/../../config');
        $config->load();

        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['EMAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['EMAIL_USERNAME'];
        $this->mail->Password   = $_ENV['EMAIL_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['EMAIL_SECURE'];
        $this->mail->Port       = $_ENV['EMAIL_PORT'];

        $this->mail->setFrom($_ENV['EMAIL_USERNAME'], "Polangui Veterinary Clinic and Grooming Center");
    }
    public function sendEmail($recipient, $subject, $message, $attachmentPath = null){
        try {
            $this->mail->isHTML(true); 
            $this->mail->addAddress($recipient);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;

            if ($attachmentPath !== null) {
                if (file_exists($attachmentPath)) {
                    $this->mail->addAttachment($attachmentPath);
                }
            }
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}