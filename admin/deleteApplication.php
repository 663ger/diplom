<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();

// Проверяем, был ли передан идентификатор заявки для удаления
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Подготовленный запрос для удаления заявки
        $stmt = $conn->prepare("DELETE FROM [VRITRF].[dbo].[Заявка] WHERE id_заявки = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Перенаправляем обратно на страницу администратора после удаления
        header("Location: adminPanel");
        exit();
    } catch(PDOException $e) {
        echo "Ошибка удаления заявки: " . $e->getMessage();
    }
} else {
    // Если id не был передан, выводим сообщение об ошибке
    echo "Идентификатор заявки не был передан.";
}
?>
