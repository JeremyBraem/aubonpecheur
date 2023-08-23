<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/SMTP.php');
require('PHPMailer/PHPMailer.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'braemjeremy08200@gmail.com';                     //SMTP username
$mail->Password   = 'rsbnrirbvxzsyxqb';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom('braemjeremy08200@gmail.com', 'Jeremy Braem');
$mail->addAddress($_SESSION['email_user']);     //Add a recipient

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Merci pour votre commande sur Au Bon Pecheur';
$mail->Body    = 
'
<h2>Merci pour votre commande !</h2>
<p>Cliquez sur le lien ci-dessous pour voir le detail et l\'avancée votre commande</p>
<a href="http://aubonpecheur/commande/numero='.$numero.'">http://aubonpecheur/commande/numero='.$numero.'</a>
<p>Récupérer votre commande en magasin une fois que celle-ci est prête.</p>
';

$mail->send();