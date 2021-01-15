<?php
// echo var_dump($_FILES);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require (__DIR__.'/php_mailer/Exception.php');
require (__DIR__.'/php_mailer/PHPMailer.php');
require (__DIR__.'/php_mailer/SMTP.php');
// $recipient_mail1 = ('962289@bk.ru');
$mail = new PHPMailer;
try {
	$mail->isSMTP();
	$mail->Host = 'mail.kaktut.pro';
	$mail->SMTPAuth = false;
	$mail->Username = 'info@kaktut.pro'; 
	$mail->Password = '9B2a9O6y'; 
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->setFrom('info@kaktut.pro'); // Ваш Email
	// $mail->addAddress($recipient_mail1); // Email получателя
	$mail->addAddress('dpodbereznyh@gmail.com'); // Email получателя
}

catch (Exception $e) {
	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


if (!empty($_FILES)) {
	foreach ($_FILES["attachment"]["error"] as $key => $error) {
	    if ($error == UPLOAD_ERR_OK) {
	        $file = $_FILES["attachment"]["tmp_name"][$key];
	        $fileName = basename($_FILES["attachment"]["name"][$key]);

	        $mail->addAttachment($file, $fileName);
	    }
	}
}
	

$message = "<h1>Тестовое задание</h1>";
if (isset($_POST['name'])) {
	$message .= "Имя: ".$_POST['name']."<br />";
}
if (isset($_POST['phone'])) {
	$message .= "Телефон: ".$_POST['phone']."<br />";
}
if (isset($_POST['email'])) {
	$message .= "Почта: ".$_POST['email']."<br />";
}
if (isset($_POST['messege'])) {
	$message .= "Сообщение: ".$_POST['messege']."<br />";
}

if (isset($_POST['title'])) {
	$message .= "Заголовок: ".$_POST['title']."<br />";
}

// Письмо
$mail->isHTML(true);
$mail->Subject = 'Заявка с Тестового задания'; // Заголовок письма
$mail->Body = $message; // Текст письма
$mail->CharSet = "utf-8";
// Результат
if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'ok';
}