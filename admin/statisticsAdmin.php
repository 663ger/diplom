<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login");
    exit();
}
?>
<?php

// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();
try {

    // Получение данных о количестве заявок по проектам
    $sql = "SELECT Проект, COUNT(id_заявки) as КоличествоЗаявок FROM Заявка GROUP BY Проект";
    $stmt = $conn->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $homePageRequests = 0;
    $razumRequests = 0;
    $cryptCloudRequests = 0;
    $photoReiRequests = 0;

    foreach ($results as $row) {
        switch ($row['Проект']) {
            case 1:
                $homePageRequests = $row['КоличествоЗаявок'];
                break;
            case 2:
                $razumRequests = $row['КоличествоЗаявок'];
                break;
            case 3:
                $cryptCloudRequests = $row['КоличествоЗаявок'];
                break;
            case 4:
                $photoReiRequests = $row['КоличествоЗаявок'];
                break;
        }
    }

    // Получение данных о посещаемости страниц
    $sqlVisits = "SELECT PageName, COUNT(id) as VisitCount FROM PageVisits GROUP BY PageName";
    $stmtVisits = $conn->query($sqlVisits);
    $visitResults = $stmtVisits->fetchAll(PDO::FETCH_ASSOC);

    $indexVisits = 0;
    $razumVisits = 0;
    $cryptCloudVisits = 0;
    $photoReiVisits = 0;

    foreach ($visitResults as $row) {
        switch ($row['PageName']) {
            case 'index':
                $indexVisits = $row['VisitCount'];
                break;
            case 'razum':
                $razumVisits = $row['VisitCount'];
                break;
            case 'criptCloud':
                $cryptCloudVisits = $row['VisitCount'];
                break;
            case 'photoRei':
                $photoReiVisits = $row['VisitCount'];
                break;
        }
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Админ панель </title>
    <link rel="stylesheet" href="../css/adminStatistics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <li><i class="fa-solid fa-house"></i><a href="#" onclick="document.location='./../admin/adminPanel?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Заявки </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/razumAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Разум </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/criptCloudAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Крипт.Клауд </a></li>
                <li><i class="fa fa-cube"></i><a href="#" onclick="document.location='./../admin/photoReiAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Фото-рэй </a></li>
                <li><i class="fa fa-plus"></i><a href="#" onclick="document.location='./../admin/featuresAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'"> Особенности </a></li>
                <li><i class="fa fa-bar-chart" style="color: rgb(8, 0, 252);"></i><a href="#" onclick="document.location='./../admin/statisticsAdmin?key=e8b7d2f4e9b47c8eaf3d5d7b9e1a2c8f9b1d4e7a8c7b8f1a3d7b8e1a4b9c8d7e'" style="color: rgb(8, 0, 252);"> Статистика </a></li>
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

            <div class="dashboard">
                <h2 class="heading">Количество заявок по проектам</h2>
                <div class="color-box">
                    <div class="box skyblue">
                        <p><i class="fa fa-cube"></i></p>
                        <p>Начальная страница</p>
                        <h3><?php echo $homePageRequests; ?></h3>
                    </div>
                    <div class="box yellow">
                        <p><i class="fa fa-cube"></i></p>
                        <p>Разум</p>
                        <h3><?php echo $razumRequests; ?></h3>
                    </div>
                    <div class="box purple">
                        <p><i class="fa fa-cube"></i></p>
                        <p>Крипт.Клауд</p>
                        <h3><?php echo $cryptCloudRequests; ?></h3>
                    </div>
                    <div class="box red">
                        <p><i class="fa fa-cube"></i></p>
                        <p>Фото-рэй</p>
                        <h3><?php echo $photoReiRequests; ?></h3>
                    </div>
                </div>
            </div>

            <div class="activity">
                <h2 class="heading">Диаграмма по количеству заявок</h2>
                <canvas id="projectChart" width="400" height="200"></canvas>
            </div>

            <div class="activity">
                <h2 class="heading">Диаграмма посещаемости страниц</h2>
                <canvas id="visitChart" width="400" height="200"></canvas>
            </div>
        </div>
    </section>

    <script>
        const homePageRequests = <?php echo $homePageRequests; ?>;
        const razumRequests = <?php echo $razumRequests; ?>;
        const cryptCloudRequests = <?php echo $cryptCloudRequests; ?>;
        const photoReiRequests = <?php echo $photoReiRequests; ?>;

        const ctxRequests = document.getElementById('projectChart').getContext('2d');
        const projectChart = new Chart(ctxRequests, {
            type: 'bar',
            data: {
                labels: ['Начальная страница', 'Разум', 'Крипт.Клауд', 'Фото-рэй'],
                datasets: [{
                    label: 'Количество заявок',
                    data: [homePageRequests, razumRequests, cryptCloudRequests, photoReiRequests],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const indexVisits = <?php echo $indexVisits; ?>;
        const razumVisits = <?php echo $razumVisits; ?>;
        const cryptCloudVisits = <?php echo $cryptCloudVisits; ?>;
        const photoReiVisits = <?php echo $photoReiVisits; ?>;

        const ctxVisits = document.getElementById('visitChart').getContext('2d');
        const visitChart = new Chart(ctxVisits, {
            type: 'bar',
            data: {
                labels: ['Начальная страница', 'Разум', 'Крипт.Клауд', 'Фото-рэй'],
                datasets: [{
                    label: 'Количество посещений',
                    data: [indexVisits, razumVisits, cryptCloudVisits, photoReiVisits],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
