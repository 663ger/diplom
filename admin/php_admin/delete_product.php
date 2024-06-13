<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    // Удаление записи из таблицы ПродуктыПроекта
    $sql = "DELETE FROM ПродуктыПроекта WHERE Продукт = $id";
    $stmt = $conn->prepare($sql);
    if($stmt->execute()) {
        // Удаление самого продукта
        $deleteProductSql = "DELETE FROM Продукт WHERE id_продукта = $id";
        $stmt2 = $conn->prepare($deleteProductSql);
        if($stmt2->execute()) {
            echo "Продукт успешно удален";
        } else {
            echo "Ошибка при удалении продукта";
        }
    } else {
        echo "Ошибка при удалении продукта из проекта";
    }
}
?>
