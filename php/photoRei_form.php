<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();
date_default_timezone_set('Asia/Yekaterinburg');

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, все ли необходимые поля заполнены
    if (isset($_POST['name']) && isset($_POST['contacts'])) {
        // Получаем данные из формы
        $name = $_POST['name'];
        $contacts = $_POST['contacts'];
        $project = 4; // Предположим, что проект имеет ID = 1
        $status = 1; // Предположим, что статус заявки имеет ID = 1
        $creationDate = date('Y-m-d H:i:s'); // Текущая дата и время

        try {
            // Подготавливаем SQL-запрос для вставки данных
            $sql = "INSERT INTO [VRITRF].[dbo].[Заявка] ([ФИОКлиента], [КонтактныеДанные], [Проект], [СтатусЗаявки], [ДатаСоздания]) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            // Выполняем запрос с передачей данных в виде параметров
            $stmt->execute([$name, $contacts, $project, $status, $creationDate]);

            // Возвращаем успешный ответ
            echo json_encode(array("success" => true));
        } catch (PDOException $e) {
            // Если произошла ошибка, возвращаем сообщение об ошибке
            echo json_encode(array("success" => false, "error" => $e->getMessage()));
        }
    } else {
        // Если не все поля заполнены, возвращаем сообщение об ошибке
        echo json_encode(array("success" => false, "error" => "Не все поля заполнены"));
    }
}
?>
