<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/forgotStyle.css">
    <title>Восстановление пароля</title>
</head>
<body>
    <div class="login-container">
        <h2>Восстановление пароля</h2>
        <form action="resetPassword.php" method="post">
            <div class="input">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Отправить</button>
            <?php if (isset($_SESSION['success_message'])) { ?>
    <p style="color: green;"><?php echo $_SESSION['success_message']; ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php } ?>

<?php if (isset($_SESSION['error_message'])) { ?>
    <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
    <?php unset($_SESSION['error_message']); ?>
<?php } ?>
<div>
<p><a href="login.php" style="color: black;">Назад</a></p>
</div>
        </form>
    </div>
</body>
</html>


