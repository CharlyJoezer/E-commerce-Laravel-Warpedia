<?php

namespace App\Http\SendEmail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail
{
    public function sendEmail($kodeotp, $toEmail)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host = 'Smtp.gmail.com';
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';
        $mail->Username = 'charlyjoezer30@gmail.com';
        $mail->Password = 'psjuxwqsiewvryjd';
        $mail->Subject = 'Warpedia Authentication';
        $mail->setFrom('charlyjoezer30@gmail.com');
        $mail->Body = '
            <h2 style="color:#333;">Kode Verifikasi Anda: <span style="color:#555;">' . $kodeotp . '</span></h2>
            <p>Terimakasih telah mengunjungi Warpedia</p>
        ';
        $mail->addAddress($toEmail);
        $mail->Send();
        $mail->smtpClose();
    }
}
