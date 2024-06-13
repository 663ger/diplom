<?php
require_once 'db_connection.php';
$conn = getConnection();

if(isset($_POST['id']) && isset($_POST['statusId'])) {
    $id = $_POST['id'];
    $statusId = $_POST['statusId'];
    $sql = "UPDATE Продукт SET СтатусПродукта = $statusId WHERE id_продукта = $id";
    $stmt = $conn->prepare($sql);
    if($stmt->execute()) {
        echo "Статус продукта успешно обновлен";
    } else {
        echo "Ошибка при обновлении статуса продукта";
    }
}
?>
