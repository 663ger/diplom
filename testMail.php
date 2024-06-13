<?php
$to = 'ramseyKonyshev@yandex.ru';
$subject = 'Тест отправки почты';
$message = 'Это тестовое письмо.';
$headers = 'From: vritrf@gmail.com' . "\r\n" .
    'Reply-To: vritrf@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers)) {
    echo 'Письмо успешно отправлено!';
} else {
    echo 'Ошибка отправки письма.';
}
?>

