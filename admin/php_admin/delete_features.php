<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из POST запроса
    $featureId = intval($_POST['id']);

    try {
        // Удаление особенности из таблицы ОсобенностиПродукта
        $deleteFeatureQuery = "DELETE FROM ОсобенностиПродукта WHERE id_особенности = :featureId";
        $featureStatement = $conn->prepare($deleteFeatureQuery);
        $featureStatement->bindParam(':featureId', $featureId);
        $featureStatement->execute();

        // Возвращаем JSON с сообщением об успешном удалении особенности
        echo json_encode(array("success" => true, "message" => "Особенность успешно удалена"));
    } catch(PDOException $e) {
        // Возвращаем JSON с сообщением об ошибке
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
}
?>
