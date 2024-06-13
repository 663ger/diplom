<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();

// Получение данных из POST-запроса
$id = $_POST['id'];
$statusId = $_POST['statusId'];

try {
    // Подготовленный запрос для обновления статуса заявки
    $stmt = $conn->prepare("UPDATE [VRITRF].[dbo].[Заявка] SET СтатусЗаявки = :statusId WHERE id_заявки = :id");
    $stmt->bindParam(':statusId', $statusId);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Возвращаем успешный статус
    http_response_code(200);
} catch(PDOException $e) {
    // В случае ошибки возвращаем статус с ошибкой и сообщение об ошибке
    http_response_code(500);
    echo "Ошибка обновления статуса заявки: " . $e->getMessage();
}
?>
