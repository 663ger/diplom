<?php
require_once 'db_connection.php';
$conn = getConnection();

if(isset($_POST['id']) && isset($_POST['fields'])) {
    $id = $_POST['id'];
    $fields = $_POST['fields'];
    // Преобразование символа рубля в HTML-кодированную версию перед сохранением в базе данных
    if(isset($fields['Цена'])) {
        $fields['Цена'] = str_replace("₽", "&#8381;", $fields['Цена']);
    }
    $sql = "UPDATE Продукт SET ";
    foreach($fields as $key => $value) {
        $sql .= "$key = '$value', ";
    }
    $sql = rtrim($sql, ', ');
    $sql .= " WHERE id_продукта = $id";
    $stmt = $conn->prepare($sql);
    if($stmt->execute()) {
        echo "Информация успешно обновлена";
    } else {
        echo "Ошибка при обновлении информации";
    }
}
?>
