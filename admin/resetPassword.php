<?php
session_start();

require_once 'db_connection.php'; // Подключение к базе данных
$conn = getConnection(); // Получение соединения с базой данных

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Получение email из формы

    try {
        // Проверка, существует ли пользователь с указанным email в базе данных
        $stmt = $conn->prepare("SELECT * FROM [VRITRF].[dbo].[Пользователь] WHERE [emai] = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Генерация нового пароля
            $new_password = generateRandomPassword(); // Генерация случайного пароля

            // Обновление пароля в базе данных
            $update_stmt = $conn->prepare("UPDATE [VRITRF].[dbo].[Пользователь] SET [пароль] = :password WHERE [emai] = :email");
            $update_stmt->bindParam(':password', $new_password);
            $update_stmt->bindParam(':email', $email);
            $update_stmt->execute();

            // Отправка нового пароля на email
            $from_email = 'vritrf@gmail.com';
            $from_name = 'VRITRF Support';
            $subject = 'Ваш новый пароль';
            $message = 'Ваш новый пароль: ' . $new_password;
            $headers = 'From: ' . $from_name . ' <' . $from_email . '>';

            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['success_message'] = "Новый пароль отправлен на ваш email.";
            } else {
                $_SESSION['error_message'] = "Ошибка при отправке письма. Пожалуйста, свяжитесь с администратором.";
            }
        } else {
            $_SESSION['error_message'] = "Пользователь с указанным email не найден.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Ошибка выполнения запроса: " . $e->getMessage();
    }

    // Перенаправление на страницу forgotPassword.php
    header("Location: forgotPassword.php");
    exit();
}

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
