<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login");
    exit();
}
?>

<?php
require_once 'db_connection.php';
$conn = getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Админ панель </title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="warning">
        <h2> Sorry, this page doesn't support your device, Please use large screen device to see this page </h2>
    </div>

    <section>
        <!-- User Sidebar Starts from Here -->
        <div class="navbar" id="navigation">
            <img src="../img/index_html/logoCirVer.png" alt="">
            <ul class="center-nav">
                <li><i class="fa-solid fa-house"style="color: rgb(8, 0, 252);" ></i><a href="#" onclick="document.location='./../admin/adminPanel?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'" style="color: rgb(8, 0, 252);"> Заявки </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/razumAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Разум </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/criptCloudAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Крипт.Клауд </a></li>
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
                <div class="input">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Поиск...">
                </div>
                <div class="user">
                    <img src="./user.png" alt="">
                </div>
            </div>
            <!-- User Activity Starts from Here -->
            <div class="activity">
                <h2 class="heading"> Просмотр заявок </h2>
                <div class="activities">
                <table>
    <thead>
        <tr>
            <th> Имя клиента </th>
            <th> Контакт клиента </th>
            <th style = "cursor: pointer;" onclick="toggleDateFilter()"> Дата <i style = "cursor: pointer;" class='fa fa-filter'></i> </th>
            <th> Проект </th>
            <th style = "cursor: pointer;"  onclick="showStatusFilter(event)"> Статус заявки <i class='fa fa-filter'></i> 
    <!-- Выпадающий список для фильтрации по статусам заявок -->
    <select class="selectStatus" id="statusFilter" style="display: none;" onclick="event.stopPropagation();">
        <option value="all">Все</option>
        <?php
        // Получаем список всех статусов заявок из базы данных и создаем опции выпадающего списка
        $statusQuery = "SELECT [id_статуса_заявки], [Название] FROM [VRITRF].[dbo].[СтатусЗаявки]";
        $statusStmt = $conn->query($statusQuery);
        while ($statusRow = $statusStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $statusRow['id_статуса_заявки'] . "'>" . $statusRow['Название'] . "</option>";
        }
        ?>
    </select>
</th>

            <th> Действие </th>
        </tr>
    </thead>
    <?php
        $query = "SELECT TOP (1000) Заявка.id_заявки, Заявка.ФИОКлиента, Заявка.КонтактныеДанные, 
            SUBSTRING(CONVERT(VARCHAR, Заявка.ДатаСоздания, 120), 1, 19) AS ДатаСоздания,
            Проект.Название AS ПроектНазвание, СтатусЗаявки.Название AS СтатусЗаявкиНазвание
            FROM [VRITRF].[dbo].[Заявка]
            INNER JOIN [VRITRF].[dbo].[Проект] ON Заявка.Проект = Проект.id_проекта
            INNER JOIN [VRITRF].[dbo].[СтатусЗаявки] ON Заявка.СтатусЗаявки = СтатусЗаявки.id_статуса_заявки";
        $stmt = $conn->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['ФИОКлиента'] . "</td>";
            echo "<td>" . $row['КонтактныеДанные'] . "</td>";
            echo "<td>" . $row['ДатаСоздания'] . "</td>";
            echo "<td>" . $row['ПроектНазвание'] . "</td>";
            echo "<td>";
            echo "<select class='selectStatus' onchange='updateStatus(" . $row['id_заявки'] . ", this.value)'>";
            // Получаем список статусов заявок из базы данных и создаем опции выпадающего списка
            $statusQuery = "SELECT [id_статуса_заявки], [Название] FROM [VRITRF].[dbo].[СтатусЗаявки]";
            $statusStmt = $conn->query($statusQuery);
            while ($statusRow = $statusStmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($statusRow['Название'] === $row['СтатусЗаявкиНазвание']) ? 'selected' : '';
                echo "<option value='" . $statusRow['id_статуса_заявки'] . "' $selected>" . $statusRow['Название'] . "</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td><a style='color: black;' href='#' onclick='deleteConfirmation(" . $row['id_заявки'] . ")'>Удалить <i class='fa fa-trash' style='color: black;'></i></a></td>";
            echo "</tr>";
        }
        ?>
</table>

<script>
function searchTable() {
    // Получаем значение из поля ввода
    var input = document.getElementById("searchInput").value.toLowerCase();
    // Получаем таблицу и её строки
    var table = document.querySelector("table");
    var rows = table.getElementsByTagName("tr");

    // Проходим по каждой строке таблицы
    for (var i = 0; i < rows.length; i++) {
        var found = false;
        // Получаем ячейки каждой строки
        var cells = rows[i].getElementsByTagName("td");
        // Проходим по каждой ячейке
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            // Проверяем, содержит ли текст в ячейке введенное значение
            if (cell.innerText.toLowerCase().indexOf(input) > -1) {
                found = true;
                break;
            }
        }
        // Если строка содержит введенное значение, отображаем её, иначе скрываем
        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
</script>

<script>
    var dateFilterAscending = true;

function toggleDateFilter() {
    var rows = document.getElementsByTagName('tr');
    var dates = [];

    // Получаем даты из каждой строки таблицы, пропуская первую строку (заголовок)
    for (var i = 1; i < rows.length; i++) {
        var dateCell = rows[i].getElementsByTagName('td')[2]; // Получаем ячейку с датой (индекс 2)
        var date = new Date(dateCell.innerText);
        dates.push({ date: date, row: rows[i] });
    }

    // Сортируем даты в зависимости от текущего порядка (возрастание или убывание)
    dates.sort(function(a, b) {
        return dateFilterAscending ? a.date - b.date : b.date - a.date;
    });

    // Обновляем порядок строк в таблице
    for (var j = 0; j < dates.length; j++) {
        rows[j + 1].parentNode.insertBefore(dates[j].row, rows[j + 1]);
    }

    // Меняем направление сортировки для следующего нажатия
    dateFilterAscending = !dateFilterAscending;
}

</script>

<script>
// Функция для показа выпадающего списка с фильтром по статусам заявок
function showStatusFilter(event) {
    var statusFilter = document.getElementById('statusFilter');
    var th = event.target.closest('th'); // Находим ближайший родительский элемент th
    // Показываем выпадающий список
    statusFilter.style.display = 'block';
    // Перемещаем выпадающий список под или внутрь элемента th
    th.appendChild(statusFilter);
    // Обрабатываем выбор значения из списка
    statusFilter.onchange = function() {
        var selectedValue = statusFilter.value;
        // Обновляем строки таблицы в соответствии с выбранным значением фильтра
        var rows = document.getElementsByTagName('tr');
        for (var i = 1; i < rows.length; i++) { // Начинаем с 1, чтобы пропустить заголовок таблицы
            var rowStatus = rows[i].getElementsByTagName('td')[4].getElementsByTagName('select')[0].value;
            if (selectedValue === 'all' || rowStatus === selectedValue) {
                rows[i].style.display = ''; // Показываем строку таблицы
            } else {
                rows[i].style.display = 'none'; // Скрываем строку таблицы
            }
        }
        // Скрываем выпадающий список после выбора значения
        statusFilter.style.display = 'none';
    };
}

</script>

<script>
// Функция для обновления статуса заявки через AJAX
function updateStatus(id, statusId) {
    if (confirm('Вы действительно хотите изменить статус заявки?')) {
        // Отправляем AJAX-запрос для обновления статуса заявки
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php_admin/updateStatus.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Если запрос успешно выполнен, перезагружаем страницу для обновления данных
                window.location.reload();
            }
        };
        xhr.send('id=' + id + '&statusId=' + statusId);
    } else {
        // Если пользователь отказался от изменения статуса, ничего не делаем
        return;
    }
}
</script>

<script>
function deleteConfirmation(id) {
    if (confirm('Вы действительно хотите удалить эту заявку?')) {
        window.location.href = 'deleteApplication.php?id=' + id;
    }
}
</script>


                </div>
            </div>
        </div>
    </section>

</body>
<script>
        function redirectToPage(url) {
            window.location.href = url;
        }
    </script>
<script>
    const hamburger = document.getElementById('menu');
    const navigation = document.getElementById('navigation');
    hamburger.addEventListener('click', function () {
        navigation.classList.toggle('active')
        console.log('clicked');
    })
</script>

</html>