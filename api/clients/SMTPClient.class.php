<?php
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

class SMTPClient {

  private $mailer;

  public function __construct(){
    $transport = (new Swift_SmtpTransport(Config::SMTP_HOST, Config::SMTP_PORT, 'tls'))
      ->setUsername(Config::SMTP_USER)
      ->setPassword(Config::SMTP_PASSWORD);

    $this->mailer = new Swift_Mailer($transport);
  } 

  public function send_register_user_token($userAccount){
    $message = (new Swift_Message('Confirm your account'))
      ->setFrom(['webproject.webshop@gmail.com' => 'Webshop'])
      ->setTo([$userAccount['email']])
      ->setBody('Here is the confirmation link: http://localhost/webshop/api/account/confirm/'.$userAccount['token']);
      
    $this->mailer->send($message);
  }

  public function send_user_recovery_token($userAccount){
    $message = (new Swift_Message('Reset Your Password'))
      ->setFrom(['webproject.webshop@gmail.com' => 'Webshop'])
      ->setTo([$userAccount['email']])
      ->setBody('Here is the recovery token: '.$userAccount['token']);

    $this->mailer->send($message);
  }

}
?>