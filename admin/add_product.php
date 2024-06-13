<?php
require_once 'db_connection.php';
$conn = getConnection();

// Получаем данные из POST запроса
$projectId = intval($_POST['project']);
$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productStatus = $_POST['productStatus'];

try {

    // Вставка данных в таблицу Продукт
    $insertProductQuery = "INSERT INTO Продукт (Название, Описание, Цена, СтатусПродукта) 
                           VALUES (:productName, :productDescription, :productPrice, :productStatus)";
    $productStatement = $conn->prepare($insertProductQuery);
    $productStatement->bindParam(':productName', $productName);
    $productStatement->bindParam(':productDescription', $productDescription);
    $productStatement->bindParam(':productPrice', $productPrice);
    $productStatement->bindParam(':productStatus', $productStatus);
    $productStatement->execute();

    // Получаем ID вставленного продукта и преобразуем его в число
    $productId = intval($conn->lastInsertId());

    // Вставка данных в таблицу ПродуктыПроекта
    $insertProjectProductQuery = "INSERT INTO ПродуктыПроекта (Проект, Продукт) 
                                  VALUES (:projectId, :productId)";
    $projectProductStatement = $conn->prepare($insertProjectProductQuery);
    $projectProductStatement->bindParam(':projectId', $projectId);
    $projectProductStatement->bindParam(':productId', $productId);
    $projectProductStatement->execute();

    // Возвращаем JSON с сообщением об успешном добавлении продукта
    echo json_encode(array("success" => true));
} catch(PDOException $e) {
    // Возвращаем JSON с сообщением об ошибке
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}
?>
