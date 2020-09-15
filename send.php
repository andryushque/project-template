<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$form = $_POST['form'];

// Формирование самого письма
if ($form == 'form-modal') {
  $title = "Message title";
  $body = "
  <h2>Body header</h2>
  <b>Name:</b> $name<br>
  <b>Email:</b> $email<br>
  <b>Password:</b>$password<br>
  ";
};

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    // $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'temp@gmail.com'; // Логин на почте (отправитель письма)
    $mail->Password   = '12345678'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('12345678@gmail.com', 'Jack Shepard'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('temp2@gmail.com');  

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
/* if ($form == 'form-modal') {
  header('Location: message.html');
}; */

echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);