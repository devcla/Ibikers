<?php
global $db;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $db->get_email($username);
        $mail_sent = false;
        $mail = new PHPMailer(true);
        $token = bin2hex(random_bytes(32));
        $link = "http://localhost/Ibikers/reset-password.php?token=$token&username=$username";

        if ($email !== 1 && $email !== -1) {

            $db->insert_token($username, $token);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'peronclaudio1@gmail.com';
            $mail->Password = 'ehjn gixv gvdt pvlh';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('peronclaudio1@gmail.com');
            
            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = "Password Reset";
            $mail->Body = "Please click on the following link to reset your password: $link\n";

            $mail_sent = $mail->send();
        
        }


        if($mail_sent == true) {
            echo 'success';
        } else {
            echo 'error';
        }
}
?>