<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'localhost'; // Adresse du serveur SMTP local
        $mail->Port = 25; // Port SMTP
        $mail->SMTPAuth = false; // Pas d'authentification SMTP requise pour un serveur local

        $mail->setFrom($email, $nom);
        $mail->addAddress('braemjeremy08200@gmail.com'); // Adresse e-mail de l'administrateur

        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de $nom";
        $mail->Body = "De: $nom<br>Email: $email<br><br>Message:<br>$message";

        $mail->send();
        echo "Message envoyé avec succès à l'administrateur.";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    }

?>
