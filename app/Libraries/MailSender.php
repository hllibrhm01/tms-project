<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use Exception;

class MailSender
{
    private $mailClient = null;

    public function __construct($userName, $password, $mailFromAddress, $mailFromName)
    {
        $this->mailClient = new PHPMailer(true); // notice the \  you have to use root namespace here
        try {
            $this->mailClient->isSMTP(); // tell to use smtp
            $this->mailClient->CharSet = "utf-8"; // set charset to utf8
            $this->mailClient->SMTPAuth = true;  // use smpt auth
            $this->mailClient->SMTPSecure = "tls"; // or ssl
            $this->mailClient->Host = env('MAIL_HOST');
            $this->mailClient->Port = 587; // 465
            $this->mailClient->setLanguage('tr', 'language/');
            $this->mailClient->Username = $userName;
            $this->mailClient->Password = $password;
            $this->mailClient->addBCC($mailFromAddress, $mailFromName);

            if (!env('APP_DEBUG'))
                $this->mailClient->addBCC("hllibrhm01@gmail.com", "Eda Erdem");

            $this->mailClient->setFrom($mailFromAddress, $mailFromName);
        } catch (Exception $e) {
        }
    }

    public function sendMail($name, $email,  $subject,  $mailContent)
    {
        $email = strtolower($email);
        if (env('APP_DEBUG'))
            $email = "halil.saridede@1k2a.net";

        try {
            $this->mailClient->Subject = $subject;
            $this->mailClient->isHTML(true);
            $this->mailClient->MsgHTML($mailContent);
            $this->mailClient->addAddress($email,  $name);
            $this->mailClient->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
