<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('kiriMail')) {
    function kiriMail($pengguna, $subject, $isiMail, $attach) 
    {
        $response = false;
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host     = 'mail.mrkitchen.co.id'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'sifu.apps@mrkitchen.co.id'; // user email
        $mail->Password = 'G@ruda7577'; // password email
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->Timeout = 60; // timeout pengiriman (dalam detik)
        $mail->SMTPKeepAlive = true;

        $mail->setFrom('sifu.apps@mrkitchen.co.id', 'SIFU APPS'); // user email
        $mail->addReplyTo('paulus.mwk@gmail.com', 'IT Administrator'); //user email

        // Add a recipient
        $mail->addAddress($pengguna); //email tujuan pengiriman email

        // Email subject
        $mail->Subject = $subject; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = $isiMail; // isi email
        $mail->Body = $mailContent;
        if($attach) {
            $mail->addAttachment($attach);
        }

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
}