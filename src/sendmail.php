<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {

    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_POST['server'];
    $mail->Port       = $_POST['port'];

    if(isset($_POST['auth']) && $_POST['auth'] == 'on' && isset($_POST['username'])){
      $mail->SMTPAuth   = true;
      $mail->Username   = $_POST['username'];
      $mail->Password   = isset($_POST['password']) ? $_POST['password'] : '';
    }

    if(isset($_POST['tls']) && $_POST['tls'] == 'on'){
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }

    // Recipients
    $mail->setFrom($_POST['fromEmail'], $_POST['fromName']);
    $mail->addAddress($_POST['to']);

    if(isset($_POST['replyTo']) && strlen($_POST['replyTo']) > 5){
      $mail->addReplyTo($_POST['replyTo']);
    }

    if(isset($_POST['cc']) && strlen($_POST['cc']) > 5){
      $mail->addCC($_POST['cc']);
    }

    if(isset($_POST['bcc']) && strlen($_POST['bcc']) > 5){
      $mail->addBCC($_POST['bcc']);
    }

    // Attachment
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
      $mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
    }

    // Content
    if($_POST['contentType'] == 'html'){
      $mail->isHTML(true);
    }
    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['content'];

    $mail->send();

    header('Content-Type: application/json');
    echo json_encode(['ok' => true]);

} catch (phpmailerException $e) {

    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'code' => $e->getCode(), 'error' => $e->getMessage()]);

} catch (Exception $e) {

    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'code' => $e->getCode(), 'error' => $e->getMessage()]);

}

