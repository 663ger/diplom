<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Админ панель </title>
    <link rel="stylesheet" href="../css/adminCriptCloud.css">
    <link rel="stylesheet" href="../css/modalAddAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div class="warning">
        <h2> Sorry, this page doesn't support your device, Please use large screen device to see this page </h2>
    </div>

    <?php
require_once 'db_connection.php';
$conn = getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из POST запроса
    $projectId = intval($_POST['projectId']);
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
        echo json_encode(array("success" => true, "message" => "Продукт успешно добавлен"));
    } catch(PDOException $e) {
        // Возвращаем JSON с сообщением об ошибке
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
} else {
    // Запрос для получения списка проектов
    $projectsQuery = "SELECT id_проекта, Название FROM Проект";
    $projectsStatement = $conn->query($projectsQuery);
    $projects = $projectsStatement->fetchAll(PDO::FETCH_ASSOC);

    // Запрос для получения списка статусов продукта
    $statusesQuery = "SELECT id_статуса_продукта, Название FROM СтатусПродукта";
    $statusesStatement = $conn->query($statusesQuery);
    $statuses = $statusesStatement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="addProductForm">
          <label for="project">Проект:</label>
          <select class="selM" id="project">
            <?php foreach ($projects as $project): ?>
              <option value="<?= $project['id_проекта'] ?>"><?= $project['Название'] ?></option>
            <?php endforeach; ?>
          </select><br>
          <label for="productName">Название продукта:</label>
          <input class="inpM" type="text" id="productName" name="productName"><br>
          <label for="productDescription">Описание продукта:</label>
          <textarea class="texM" id="productDescription" name="productDescription"></textarea><br>
          <label for="productPrice">Цена:</label>
          <input class="inpM" type="text" id="productPrice" name="productPrice"><br>
          <label for="productStatus">Статус продукта:</label>
          <select class="selM" id="productStatus" name="productStatus">
            <?php foreach ($statuses as $status): ?>
              <option value="<?= $status['id_статуса_продукта'] ?>"><?= $status['Название'] ?></option>
            <?php endforeach; ?>
          </select><br>
          <button class = "butM" type="button" onclick="addProduct()">Добавить</button>
        </form>
      </div>
    </div>
<?php } ?>


<script>
    function addProduct() {
        var form = document.getElementById('addProductForm');
        var formData = new FormData(form);
        
        // Получаем выбранный проект
        var projectId = document.getElementById('project').value;
        // Добавляем projectId в formData
        formData.append('projectId', projectId);
        
        // Отправляем данные на сервер
        fetch('criptCloudAdmin.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Проверяем, был ли успешно добавлен продукт
            if (data.success) {
                // Выводим сообщение об успешном добавлении продукта
                alert(data.message);
                // Закрываем модальное окно
                closeModal();
            } else {
                // Если добавление продукта не удалось, выводим сообщение об ошибке
                alert('Ошибка при добавлении продукта: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Ошибка при добавлении продукта:', error);
        });
    }

    function openModal() {
        document.getElementById('myModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('myModal').style.display = "none";
    }
</script>



    <section>
        <!-- User Sidebar Starts from Here -->
        <div class="navbar" id="navigation">
        <img src="../img/index_html/logoCirVer.png" alt="">
            <ul class="center-nav">
                <li><i class="fa-solid fa-house" ></i><a href="#" onclick="document.location='./../admin/adminPanel?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Заявки </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/razumAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Разум </a></li>
                <li><i class="fa fa-cube" style="color: rgb(8, 0, 252);"></i><a href="#" onclick="document.location='./../admin/criptCloudAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'" style="color: rgb(8, 0, 252);"> Крипт.Клауд </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/photoReiAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Фото-рэй </a></li>
                <li><i class="fa fa-plus"></i><a href="#" onclick="document.location='./../admin/featuresAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Особенности </a></li>
                <li><i class="fa fa-bar-chart"></i><a href="#" onclick="document.location='./../admin/statisticsAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Статистика </a></li>
            </ul>
            <ul class="bottom-nav">
                <hr>
                <li><i class="fa-solid fa-power-off"></i><a href="logout.php"> Выход </a></li>
            </ul>
        </div>

        <!-- User Top Naviagation Starts from Here -->
        <div class="main-content">
            <div class="main-top">
                <div class="bars" id="menu">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <div class="user">
                    <img src="./user.png" alt="">
                </div>
            </div>

            <!-- User Activity Starts from Here -->
            <div class="activity" style="overflow: auto;">
            <h2 class="heading" style="float: left;"> Продукты проекта: Крипт.Клауд </h2>
            <h2 class="heading add-product" style="float: right;" onclick="openModal()"> Добавить продукт </h2>
                <div class="activities">
                <?php
require_once 'db_connection.php';
$conn = getConnection();

// SQL запрос для получения данных
$sql = "SELECT Продукт.id_продукта, Продукт.Название, Продукт.Описание, Продукт.Цена, СтатусПродукта.id_статуса_продукта, СтатусПродукта.Название AS Статус
        FROM Продукт
        INNER JOIN ПродуктыПроекта ON Продукт.id_продукта = ПродуктыПроекта.Продукт
        INNER JOIN СтатусПродукта ON Продукт.СтатусПродукта = СтатусПродукта.id_статуса_продукта
        WHERE ПродуктыПроекта.Проект = 3";

// Выполнение запроса
$result = $conn->query($sql);

// Вывод результатов в таблицу
echo "<table id='products_table'>
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Статус продукта</th>
                <th>Редактирование</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>";

foreach($result as $row) {
    echo "<tr>
            <td><input type='text' value='".$row['Название']."' data-id='".$row['id_продукта']."' class='edit' data-field='Название'></td>
            <td><input type='text' value='".$row['Описание']."' data-id='".$row['id_продукта']."' class='edit' data-field='Описание'></td>
            <td><input type='text' value='".$row['Цена']."' data-id='".$row['id_продукта']."' class='edit' data-field='Цена'></td>
            <td>
                <select class='status' data-id='".$row['id_продукта']."'>
                    <option value='".$row['id_статуса_продукта']."'>".$row['Статус']."</option>";
                    // Запрос для получения всех статусов
                    $statusSql = "SELECT * FROM СтатусПродукта";
                    $statusResult = $conn->query($statusSql);
                    foreach($statusResult as $statusRow) {
                        echo "<option value='".$statusRow['id_статуса_продукта']."'>".$statusRow['Название']."</option>";
                    }
            echo "</select>
            </td>
            <td><button class='save' data-id='".$row['id_продукта']."'>Сохранить</button></td>
            <td><button class='delete' data-id='".$row['id_продукта']."'>Удалить</button></td>
          </tr>";
}
echo "</tbody></table>";
?>

<script>
    $(document).ready(function(){
        $('.save').click(function(){
            var id = $(this).data('id');
            var fields = {};
            $(this).closest('tr').find('.edit').each(function(){
                fields[$(this).data('field')] = $(this).val();
            });
            $.ajax({
                url: 'php_admin/update_product.php',
                method: 'POST',
                data: { id: id, fields: fields },
                success: function(response){
                    alert(response);
                }
            });
        });

        $('.status').change(function(){
            var id = $(this).data('id');
            var statusId = $(this).val();
            $.ajax({
                url: 'php_admin/update_product_status.php',
                method: 'POST',
                data: { id: id, statusId: statusId },
                success: function(response){
                    alert(response);
                }
            });
        });

        $('.delete').click(function(){
        // Запрашиваем подтверждение удаления
        if (confirm('Вы действительно хотите удалить продукт?')) {
            var id = $(this).data('id');
            $.ajax({
                url: 'php_admin/delete_product.php',
                method: 'POST',
                data: { id: id },
                success: function(response){
                    alert(response);
                }
            });
        }
    });
});
</script>

                </div>
            </div>
        </div>
    </section>

</body>

<script>
    const hamburger = document.getElementById('menu');
    const navigation = document.getElementById('navigation');
    hamburger.addEventListener('click', function () {
        navigation.classList.toggle('active')
        console.log('clicked');
    })
</script>

</html>