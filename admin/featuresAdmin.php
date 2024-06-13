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
    <link rel="stylesheet" href="../css/adminFeatures.css">
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
    $productId = intval($_POST['productId']);
    $featureName = $_POST['featureName'];

    try {
        // Вставка данных в таблицу ОсобенностиПродукта
        $insertFeatureQuery = "INSERT INTO ОсобенностиПродукта (Название, Продукт) 
                               VALUES (:featureName, :productId)";
        $featureStatement = $conn->prepare($insertFeatureQuery);
        $featureStatement->bindParam(':featureName', $featureName);
        $featureStatement->bindParam(':productId', $productId);
        $featureStatement->execute();

        // Возвращаем JSON с сообщением об успешном добавлении особенности
        echo json_encode(array("success" => true, "message" => "Особенность успешно добавлена"));
    } catch(PDOException $e) {
        // Возвращаем JSON с сообщением об ошибке
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
} else {
    // Запрос для получения списка продуктов
    $productsQuery = "SELECT id_продукта, Название FROM Продукт";
    $productsStatement = $conn->query($productsQuery);
    $products = $productsStatement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="addFeaturesForm">
          <label for="product">Продукт:</label>
          <select class="selM" id="product">
            <?php foreach ($products as $product): ?>
              <option value="<?= $product['id_продукта'] ?>"><?= $product['Название'] ?></option>
            <?php endforeach; ?>
          </select><br>
          <label for="featureName">Название особенности:</label>
          <input class="inpM" type="text" id="featureName" name="featureName"><br>
          <button class = "butM" type="button" onclick="addFeature()">Добавить</button>
        </form>
      </div>
    </div>
<?php } ?>


<script>
    function addFeature() {
        var productId = document.getElementById('product').value;
        var featureName = document.getElementById('featureName').value;

        // Отправляем данные на сервер
        fetch('featuresAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'productId=' + encodeURIComponent(productId) + '&featureName=' + encodeURIComponent(featureName)
        })
        .then(response => response.json())
        .then(data => {
            // Проверяем, была ли успешно добавлена особенность
            if (data.success) {
                // Выводим сообщение об успешном добавлении особенности
                alert(data.message);
                // Закрываем модальное окно
                closeModal();
            } else {
                // Если добавление особенности не удалось, выводим сообщение об ошибке
                alert('Ошибка при добавлении особенности: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Ошибка при добавлении особенности:', error);
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
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/razumAdmin'"> Разум </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/criptCloudAdmin'"> Крипт.Клауд </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/photoReiAdmin'"> Фото-рэй </a></li>
                <li><i class="fa fa-plus" style="color: rgb(8, 0, 252);"></i><a href="#" onclick="document.location='./../admin/featuresAdmin'" style="color: rgb(8, 0, 252);"> Особенности </a></li>
                <li><i class="fa fa-bar-chart"></i><a href="#" onclick="document.location='./../admin/statisticsAdmin'"> Статистика </a></li>
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
            <h2 class="heading" style="float: left;"> Особенности продуктов </h2>
            <h2 class="heading add-product" style="float: right;" onclick="openModal()"> Добавить особенность </h2>
                <div class="activities">
                <?php
require_once 'db_connection.php';
$conn = getConnection();

// SQL запрос для получения данных об особенностях продуктов
$sql = "SELECT ОсобенностиПродукта.id_особенности, ОсобенностиПродукта.Название AS Особенность, Продукт.Название AS Продукт
        FROM ОсобенностиПродукта
        INNER JOIN Продукт ON ОсобенностиПродукта.Продукт = Продукт.id_продукта";

// Выполнение запроса
$result = $conn->query($sql);

// Вывод результатов в таблицу
echo "<table id='features_table'>
        <thead>
            <tr>
                <th>Особенность</th>
                <th style='position: relative; cursor: pointer;' onclick='toggleProductFilter()'>
                    <!-- Выпадающий список для выбора продукта -->
                    <select class='selF' id='productFilter'>
                        <option value=''>Все продукты</option>";
                        $productSql = "SELECT DISTINCT Продукт.Название FROM ОсобенностиПродукта INNER JOIN Продукт ON ОсобенностиПродукта.Продукт = Продукт.id_продукта";
                        $products = $conn->query($productSql)->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($products as $product) {
                            echo "<option value='$product'>$product</option>";
                        }
echo "              </select>
                    <i style='cursor: pointer;' class='fa fa-filter'></i>
                </th>
                <th>Редактирование</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>";

foreach($result as $row) {
    echo "<tr data-product='".$row['Продукт']."'>
            <td><input type='text' value='".$row['Особенность']."' data-id='".$row['id_особенности']."' class='edit' data-field='Название'></td>
            <td>".$row['Продукт']."</td>
            <td><button class='save' data-id='".$row['id_особенности']."'>Сохранить</button></td>
            <td><button class='delete' data-id='".$row['id_особенности']."'>Удалить</button></td>
          </tr>";
}
echo "</tbody></table>";
?>

<script>
$(document).ready(function(){
    // Обработчик события изменения значения в выпадающем списке продукта
    $('#productFilter').change(function() {
        var selectedProduct = $(this).val();
        if (selectedProduct) {
            // Скрытие всех строк таблицы, которые не соответствуют выбранному продукту
            $('#features_table tbody tr').hide();
            $('#features_table tbody tr[data-product="'+selectedProduct+'"]').show();
        } else {
            // Если выбрано "Все продукты", отображаем все строки таблицы
            $('#features_table tbody tr').show();
        }
    });
});
</script>




<script>
$(document).ready(function(){
    $('.save').click(function(){
        var id = $(this).data('id');
        var newName = $(this).closest('tr').find('.edit').val();
        $.ajax({
            url: 'php_admin/update_features.php', // Путь к обработчику на сервере
            method: 'POST',
            data: { id: id, newName: newName },
            success: function(response){
                alert(response);
            }
        });
    });
});

 $(document).ready(function(){
    $('.delete').click(function(){
        // Запрашиваем подтверждение удаления
        if (confirm('Вы действительно хотите удалить особенность?')) {
            var id = $(this).data('id');
            $.ajax({
                url: 'php_admin/delete_features.php',
                method: 'POST',
                data: { id: id },
                success: function(response){
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