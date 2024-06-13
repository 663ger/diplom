<?php
require_once 'db_connection.php';
$conn = getConnection();

// Получаем данные из POST запроса
$id = $_POST['id'];
$newName = $_POST['newName'];

try {
    // SQL запрос для обновления данных
    $sql = "UPDATE ОсобенностиПродукта SET Название = :newName WHERE id_особенности = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':newName', $newName);
    $statement->bindParam(':id', $id);
    $statement->execute();

    echo "Особенность успешно обновлена!";
} catch(PDOException $e) {
    // Если произошла ошибка, выводим сообщение об ошибке
    echo "Ошибка: " . $e->getMessage();
}
?>
