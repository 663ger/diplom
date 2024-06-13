<?php
// db_connection.php
function getConnection() {
    // Параметры подключения к базе данных
    $serverName = "DESKTOP-HURB5A2\\SQLEXPRESS";
    $databaseName = "VRITRF";
    $username = ""; // Добавьте имя пользователя для подключения к базе данных
    $password = ""; // Добавьте пароль для подключения к базе данных

    try {
        // Подключение к базе данных
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$databaseName", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}
?>
