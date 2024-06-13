<?php
session_start();

require_once 'db_connection.php';
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    try {
        // Поиск пользователя в базе данных
        $stmt = $conn->prepare("SELECT [логин], [пароль] FROM [VRITRF].[dbo].[Пользователь] WHERE [логин] = :username");
        $stmt->bindParam(':username', $input_username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $input_password === $user['пароль']) {
            $_SESSION['is_admin'] = true;
            header("Location: adminPanel.php");
            exit();
        } else {
            $error_message = "Неверный логин или пароль.";
        }
    } catch (PDOException $e) {
        $error_message = "Ошибка выполнения запроса: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
</head>
<body>
    <div class="login-container">
        <img src="../img/index_html/logoCirVer.png" alt="Логотип компании">
        <form method="post" action="">
            <div class="input">
                <label for="username">Логин:</label>
                <input type="text" id="username" name="username" placeholder="Введите свой логин" required>
            </div>
            <div class="input">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" placeholder="Введите пароль" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            
            <button type="submit">Войти</button>
            <?php if (isset($error_message)) { ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php } ?>
        </form>
        <p><a href="forgotPassword.php"  style="color: black;">Забыли пароль?</a></p>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var passwordFieldType = passwordField.getAttribute('type');
            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
            } else {
                passwordField.setAttribute('type', 'password');
            }
        }
    </script>
</body>
</html>
