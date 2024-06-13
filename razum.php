<?php
// Подключение к базе данных
require_once 'db_connection.php';
$conn = getConnection();

date_default_timezone_set('Asia/Yekaterinburg');

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из POST-запроса
    $fioClient = isset($_POST['fioClient']) ? trim($_POST['fioClient']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';

    // Проверяем, что поля fioClient и contact не пустые
    if (!empty($fioClient) && !empty($contact)) {
        // Устанавливаем текущую дату и время
        $dateCreated = date('Y-m-d H:i:s');

        // Запрос на добавление новой заявки
        $sql = "INSERT INTO Заявка (ФИОКлиента, КонтактныеДанные, Проект, СтатусЗаявки, ДатаСоздания) 
                VALUES (:fioClient, :contact, 2, 1, :dateCreated)";

        // Подготавливаем запрос
        $stmt = $conn->prepare($sql);

        // Привязываем параметры
        $stmt->bindParam(':fioClient', $fioClient);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':dateCreated', $dateCreated);

        // Выполняем запрос
        if ($stmt->execute()) {
            // Если запрос выполнен успешно, отправляем успешный HTTP-ответ
            http_response_code(200);
        } else {
            // Если возникла ошибка, отправляем HTTP-ответ с кодом ошибки
            http_response_code(500);
            echo "Ошибка при выполнении запроса";
        }
    } else {
        // Если одно из полей пустое, отправляем HTTP-ответ с кодом ошибки
        http_response_code(400);
        echo "Одно или оба поля не заполнены";
    }
} else {
    // Если запрос не был POST, отправляем HTTP-ответ с кодом ошибки
    http_response_code(405);
    echo "Метод не разрешен";
}
?>
<?php
// Подключение к базе данных
try {
    require_once 'db_connection.php';
    $conn = getConnection();

    // Получение имени текущего файла
    $currentPage = basename(__FILE__, '.php');
    
    // Вставка записи о посещении
    $sql = "INSERT INTO PageVisits (PageName, VisitDate) VALUES (:pageName, GETDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['pageName' => $currentPage]);

} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>

<?php?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<!-- Google tag (gtag.js) -->
	<script async="" src="gtag/js?id=G-BSKYT19TEP"></script>
	<script>
  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());

  	gtag('config', 'G-BSKYT19TEP');
	</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>РАЗУМ | ВР-ИТ.РФ</title>
    <link rel="stylesheet" href="css/razumStyle.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Gilroy:wght@500&display=swap">
    <link rel="icon" href="img/index_html/ВР.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="yandex-verification" content="e03839497f7d84fa">
    <meta name="google-site-verification" content="f_VMFVf7LmSJY7WJC0gDzfOfUtl4ZHVy_v3BJqt47f4">
	<meta name="description" content="Индивидуальная разработка от команды ВР. Опыт более 6-ти лет. Разрабатываем сложные веб-сервисы, мобильные приложения и программное обеспечение.">
	<meta property="og:description" content="Индивидуальная разработка от команды ВР. Опыт более 6-ти лет. Разрабатываем сложные веб-сервисы, мобильные приложения и программное обеспечение.">
    <script src="widget/tsv8S9r13m" async=""></script>
</head>
<body>
<div class="full_thanks">
        <div class="popup_thanks">
            <p class="thanks_span">СПАСИБО<l style="color: #fff;">, ЧТО ОСТАВИЛИ</l> ЗАЯВКУ</p>
            <p class="close" onclick="closeThanks()">Закрыть</p>
        </div>
    </div>
    <div class="full_warning">
        <div class="popup_warning">
            <div style="text-align: right;">
                <img class="popup_cross" onclick="clodeWarning()" src="img/index_html/cross_close.svg" alt="">
            </div>
            <p class="name_popup">Ошибка!</p>
            <p class="text_popup"></p>
        </div>
    </div>
    <div class="full_popup_backcall">
        <div class="popup_backcall">
            <div style="text-align: right;">
                <img class="popup_cross" onclick="backcall()" src="img/index_html/cross_close.svg" alt="">
            </div>
            <p class="name_popup">Заявка на <l style="color: #5CC3FD;">обратный звонок</l> </p>
            <form class="pop_form sendBackPopForm">
                <input class="pop_input" name="fioClient" type="text" placeholder="Как вас зовут?">
                <input class="pop_input" name="contact" type="text" placeholder="Номер телефона или почта">
                <button class="pop_button">Отправить</button>
            </form>
            <p class="agreement">При нажатии на кнопку «Отправить», я даю согласие на обработку <a href="#" style="text-decoration: underline; color: black;">Персональных данных.</a></p>
        </div>
    </div>
    <div class="full_popup_vacancy">
        <div class="popup_vacancy">
            <div style="text-align: right; margin-top: 10px;">
                <img class="popup_cross" onclick="vacancy()" src="img/index_html/cross_close.svg" alt="">
            </div>
            <p class="name_popup">Оставьте свои <l style="color: #5CC3FD;">контактные данные </l>и мы с вами свяжемся </p>
            <form class="pop_form sendBackVacancyForm">
                <input class="pop_input" name="name" type="text" placeholder="Как вас зовут?">
                <input class="pop_input" name="contact" type="text" placeholder="Номер телефона или почта">
                <input class="pop_input" name="specialization" type="text" placeholder="Кем хотите быть в компании">
                <button class="pop_button">Отправить</button>
            </form>
            <p class="agreement">При нажатии на кнопку «Отправить», я даю согласие на обработку <a href="#" style="text-decoration: underline; color: black;">Персональных данных.</a></p>
        </div>
    </div>  
    <div class="main_container" id="Главная">
        <div class="header">
            <div class="leftpart">
                <img src="img/index_html/VR.svg" onclick="document.location='./../diplom/index'" class="logo">
            <div class="navbar">
                <a onclick="scrollToElement('Тарифы')">ПРОДУКТЫ</a>
                <a onclick="scrollToElement('Преимущества')">ПРЕИМУЩЕСТВА</a>
                <a onclick="scrollToElement('Контакты')">КОНТАКТЫ</a>
            </div>
            </div>
            <div class="rightpart">
                <div class="connection_phone_header">
                    <p class="phone_header">+7 (995) 668 35-84</p>
                    <p class="link_header" onclick="backcall()">Заказать <l style="color: #5CC3FD;">обратный звонок</l></p>
                </div>
                <div class="burger" onclick="navopen()"></div>
                <div class="nav">
                    <img class="cross" onclick="navopen()" src="img/index_html/cross_close.svg" alt="">
                    <div class="points">
                        <div class="nav_point" onclick="scrollToElement('Товар')">ТОВАР</div>
                        <div class="nav_point" onclick="scrollToElement('Тарифы')">ПРОДУКТЫ</div>
                        <div class="nav_point" onclick="scrollToElement('Преимущества')">ПРЕИМУЩЕСТВА</div>
                        <div class="nav_point" onclick="scrollToElement('ОтветыНаВопросы')">ОТВЕТЫ НА ВОПРОСЫ</div>
                        <div class="nav_point" onclick="scrollToElement('Контакты')">КОНТАКТЫ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cloud_container">
        <div class="content">
            <div class="sitename">
                <p><l style="color: white; margin-right: 0;">РА</l><l style="color: #5CC3FD;">ЗУМ</l></p>
            </div>
            <div class="firstdescription">
                <p style="color: white;">
                    АВТОПИЛОТ <l style="color: #5CC3FD;">6-ОГО</l> ПОКОЛЕНИЯ <br>
                    БЕЗ <l style="color: #5CC3FD;">GPS</l> И <l style="color: #5CC3FD;">ИНТЕРНЕТА</l>
                </p>
            </div>
            <div class="orderproject" onclick="scrollToElement('Тарифы')">
                СМОТРЕТЬ ПРОДУКТЫ
            </div>
        </div>
    </div>
    
    <div class="main_container">
        <div class="divname" id="Товар">
            <p><l style="color: white;">ТОВАР</l></p>
        </div>
        <div class="product">
            <div class="pro_title">
                <p class="pro_name">РА<l style="color: #5CC3FD; margin-right: 0;">ЗУМ</l> - ЭТО АВТОПИЛОТ 6-ОГО ПОКОЛЕНИЯ,</p>
                <p class="pro_name">КОТОРЫЙ МОЖЕТ РАБОТАТЬ БЕЗ GPS И</p>
                <p class="pro_name">ИНТЕРНЕТА</p>
            </div>
            <div class="how_it_work">
                <img class="cub_cript" src="img/index_html/shapes.svg" alt="">
                <div class="how_text_content">
                    <p class="p1_how">КАК ЭТО <span style="color: #5CC3FD;">РАБОТАЕТ?</span></p>
                    <p class="p_how">"Разум" может находить объекты<br>
                        с помощью машинного зрения</p>
                </div>
            </div>
            <div class="how_it_work2">
                <div class="how_text_content2">
                    <p class="p_how2">Также "Разум" может измерять<br>расстояние до объектов</p>
                    <div class="orderproject_2" onclick="scrollToElement('Тарифы')">
                        СМОТРЕТЬ ПРОДУКТЫ
                    </div>
                </div>
                <img class="cub_cript2" src="img/index_html/shapes2.svg" alt="">
            </div>            
            <div class="integration">
                <div class="integration_content">
                    <p class="pro_name">РАЗУМ МОЖЕТ <span style="color: #5CC3FD;">ИНТЕГРИРОВАТЬСЯ</span> С</p>
                    <p class="pro_name">ЦИФРОВЫМИ ИЗМЕРИТЕЛЬНЫМИ ПРИБОРАМИ</p>
                    <p class="p_int">Это такие приборы, как:</p>
                    <div class="int_img">
                    <img class="" src="img/index_html/lidar.svg" alt="">
                    <img class="" src="img/index_html/modul_camera.svg" alt="">
                    <img class="" src="img/index_html/modul_icrana.png" alt="">
                    </div>
                    <div class="int_p">
                        <p class="p_int1">Лидар</p>
                        <p class="p_int2">Модуль камеры</p>
                        <p class="p_int3">Модуль экрана</p>
                    </div>
                </div>
            </div>
            <div class="usage">
                <div class="usage_text_content">
                    <p class="usage_name">ГДЕ МОЖЕТ ПРИМЕНЯТЬСЯ РАЗУМ?</p>
                    <div class="use_img">
                    <img class="" src="img/index_html/bpla.svg" alt="">
                    <img class="" src="img/index_html/bpa_water.svg" alt="">
                    <img class="" src="img/index_html/bpa_road.svg" alt="">
                    </div>
                </div>
            </div>
    </div>
    <div class="main_container">
        <div class="products">
        <div class="divname" id="Тарифы">
            <p><l style="color: white;">ПРОДУКТЫ</l></p>
        </div>
        <?php
try {
    // Подключение к базе данных
    require_once 'db_connection.php';
$conn = getConnection();

    // Выполнение запроса к базе данных для продуктов, связанных с проектом 2
    $stmt = $conn->prepare("SELECT [Продукт] FROM [VRITRF].[dbo].[ПродуктыПроекта] WHERE [Проект] = ?");
    $projectId = 2;
    $stmt->execute([$projectId]);

    // Вывод информации о каждом продукте
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['Продукт'];

        // Выполнение запроса для получения информации о продукте и его статуса
        $stmtProduct = $conn->prepare("SELECT [Название], [Описание], [Цена], [СтатусПродукта] FROM [VRITRF].[dbo].[Продукт] WHERE [id_продукта] = ?");
        $stmtProduct->execute([$productId]);
        $productInfo = $stmtProduct->fetch(PDO::FETCH_ASSOC);

        // Выполнение запроса для получения названия статуса продукта
        $stmtStatus = $conn->prepare("SELECT [Название] FROM [VRITRF].[dbo].[СтатусПродукта] WHERE [id_статуса_продукта] = ?");
        $stmtStatus->execute([$productInfo['СтатусПродукта']]);
        $statusInfo = $stmtStatus->fetch(PDO::FETCH_ASSOC);

        // Вывод информации о продукте
        echo '<div class="tarrifs_content2">';
        echo '<div class="div01">' . $productInfo['Название'] . '</div>';
        echo '<div class="_599">' . $productInfo['Цена'] . '</div>';
        echo '<div class="_1-01">' . $productInfo['Описание'] . '</div>';
        // Выполнение запроса для получения особенностей продукта
        $stmtFeatures = $conn->prepare("SELECT [Название] FROM [VRITRF].[dbo].[ОсобенностиПродукта] WHERE [Продукт] = ?");
        $stmtFeatures->execute([$productId]);

        // Вывод особенностей в формате списка
        echo '<ul class="feature_с1">';
        while ($feature = $stmtFeatures->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>' . $feature['Название'] . '</li>';
        }
        echo '</ul>';
        // Вывод названия статуса продукта на кнопке
        echo '<div class="buytariff" onclick="backcall()">' . $statusInfo['Название'] . '</div>';
        echo '<div class="boxtarrif1"></div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>

    </div>
    <div class="main_container">
        <div class="divname" id="Преимущества">
            <p style="color: white;">ПРЕИМУЩЕСТВА</p>
        </div>
        <div class="assets">
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/1</p>
                <p class="textasset" style="color: white">Поиск объектов с<br>помощью машинного<br>зрения</p>
                <img class="" src="img/index_html/icon-vision.svg" alt="">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/2</p>
                <p class="textasset2" style="color: white">Работа без интернета</p>
                <img class="" src="img/index_html/icon-no-wifi.svg" alt="">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/3</p>
                <p class="textasset3" style="color: white">Синхронизация с<br>любыми цифровыми
                    <br>прибороми</p>
                    <img class="" src="img/index_html/syncing.svg" alt="">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/4</p>
                <p class="textasset2" style="color: white">Доверительная ОС</p>
                <img class="" src="img/index_html/verified.svg" alt="">
            </div>
            <div class="asset bl">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/5</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">ОСТАЛИСЬ<br>ВОПРОСЫ</p>
                <p class="textasset" style="color: white">Задайте их нам!</p>
                <div class="buyproduct"onclick="backcall()">
                    ЗАДАТЬ ВОПРОС
                </div>
            </div>
        </div>
    </div>
    <div class="main_container">
        <div class="divname" id="СтекТехнологий">
            <p style="color: white;">ТЕСТИРОВАНИЕ НА<br>“<l style="color: #5CC3FD;">БИТВЕ</l> РОБОТОВ”</p>
        </div>
        <div class="robot">
            <img class="robo_img" src="img/index_html/Screenshot_robot.svg" alt="">
            <div class="robot_content">
                <p class="p1_rob"><span style="color: #5CC3FD;">РАЗУМ</span> И РОБОТ</p>
                <p class="p_rob">На чемпионате “Битва Роботов”,<br>
                    проходившем в конце октября 2023<br>года, Разум был встроен в нашего<br>
                    робота под названием “Headliner”.</p>
            </div>
        </div>
        <div class="robot2">
            <img class="robo_img2" src="img/index_html/Screenshot_team.svg" alt="">
            <div class="robot_content2">
                <p class="p1_rob2">ЧТО В ИТОГЕ?</p>
                <p class="p_rob2">“Headliner” показал себя достойно,<br>
                     не выйдя из строя. Ведь робот<br>
                     благодаря Разуму мог определять<br>
                     опасность и понимал, когда ему<br>
                     нужно выждать момент для атаки.</p>
            </div>
        </div>
    </div>

    <div class="main_container">
        <div class="divname" id="ОтветыНаВопросы">
            <p style="color: #5CC3FD;">ОСТАЛИСЬ <l style="color: white;">ВОПРОСЫ? </l></p>
        </div>
        <div class="consult_titile">
            <div class="consult">
                Закажите <l style="color: #5CC3FD;"> обратный звонок! </l>
            </div>
            
        </div>
        <div class="consult_text">
            <l style="color: white; white-space: nowrap;">Проконсультируем по каждому из товаров сразу, на первом созвоне. </l>
            <l style="color: white;">Бесплатно и без обязательств.</l>
        </div>
        <form class="main_form" id="myForm">
    <input class="quest_input" name="name" type="text" placeholder="Как к Вам обращаться?">
    <input class="quest_input" name="contacts" type="text" placeholder="Номер телефона или почта">
    <button class="form_btn" type="submit">
        <l class="btn_text">Отправить</l>
        <img src="img/index_html/arrow-form-btn.svg" class="btn_img">
    </button>
    <p class="marking">
        При нажатии на кнопку "Отправить", я даю согласие на обработку <a href="">Персональных данных.</a>
    </p>
</form>
<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Предотвращаем стандартное действие отправки формы

        var formData = new FormData(this);

        // Проверяем, все ли поля заполнены
        if (formData.get('name') === '' || formData.get('contacts') === '') {
            openingWarning('Заполните все поля');
            return; // Прерываем выполнение функции, если поля не заполнены
        }

        // Проверка корректности введенного номера телефона
        var contactsValue = formData.get('contacts');
        if (!isValidPhoneNumber(contactsValue) && !isValidEmail(contactsValue)) {
            openingWarning('Введите корректный номер телефона или email');
            return; // Прерываем выполнение функции, если номер телефона или email некорректны
        }

        fetch('php/razum_form.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showingThanksPopup();
                document.getElementById('myForm').reset();
            } else {
                openingWarning('Произошла ошибка: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function openingWarning(message) {
        const warningText = document.querySelector('.text_popup');
        warningText.textContent = message;
        document.querySelector('.full_warning').classList.add('active');
        document.querySelector('.popup_warning').classList.add('active');
    }

    function closingWarning() {
        document.querySelector('.full_warning').classList.remove('active');
        document.querySelector('.popup_warning').classList.remove('active');
    }

    function showingThanksPopup() {
        document.querySelector('.full_thanks').classList.add('active');
        document.querySelector('.popup_thanks').classList.add('active');
    }

    function closingThanks() {
        document.querySelector('.full_thanks').classList.remove('active');
        document.querySelector('.popup_thanks').classList.remove('active');
    }

    function isValidPhoneNumber(phoneNumber) {
        // Проверяем, начинается ли номер с +7, +8, 7 или 8, а затем следуют 10 цифр
        return /^(?:\+7|\+8|7|8)\d{10}$/.test(phoneNumber);
    }

    function isValidEmail(email) {
        // Простая проверка на корректность email с использованием регулярного выражения
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
</script>
        <div class="consult_titile">
            <div class="consult">
                Вы можете задать <l style="color: #5CC3FD;"> любой вопрос </l> в мессенджере или <l style="color: #5CC3FD;">по телефону</l>
            </div>
        </div>
        <div class="connection">
            <div class="connection_tg">
                <a href="https://t.me/ooo_vebrazrabotka" class="telegram">Связаться через <l style="color: #5CC3FD;  margin-top: auto; margin-bottom: auto;"> Telegram</l></a>
                <img src="img/index_html/tg-icon_50x50.svg" alt="" style="margin-left: 13px;">
            </div>
            <div class="connection_phone">
                <p class="phone">+7 (995) 668 35-84</p>
                <p class="link" onclick="backcall()">Заказать <l style="color: #5CC3FD;">обратный звонок</l></p>
            </div>
        </div>
    </div>
    <div class="main_container">
        <div class="divname" id="Партнеры">
            <p style="color: white;">ПАРТ<l style="color: #5CC3FD;">НЕРЫ</l></p>
        </div>
        <div class="partners">
            <img src="img/index_html/ASI_partner.svg" alt="">
            <img src="img/index_html/Morion_partner.svg" alt="">
            <img src="img/index_html/%D0%A6%D0%94%D0%9F_partner.svg" alt="">
            <img src="img/index_html/%D0%90%D0%98%D0%A0_%20partner.svg" alt="">
        </div>
    </div>
    
    <a href="php/send_main_form.php.html"></a>
    <div class="main_container">
        <div class="divname" id="Контакты">
            <p style="color: white;">КОН<l style="color: #5CC3FD;">ТАКТЫ</l></p>
        </div>
        <div class="contacts">
            <div>
                <p class="company_name">OOO <l style="color: #5CC3FD;">"ВЕБ РАЗРАБОТКА"</l></p>
                <p class="contact"><l style="color: white;">Почта: </l>vr-it.info@yandex.ru</p>
                <p class="contact"><l style="color: white;">Телефон: </l>+7 (995) 668-35-84</p>
                <p class="contact"><l style="color: white;">Адрес: </l>шоссе космонавтов, д. 111д, подъезд 3, оф. 3</p>
                <a class="contact" href="https://vk.com/vr_it_ru" style="text-decoration: underline; text-decoration-color: white; cursor: pointer;"><l style="color: white;">Мы </l>Вконтакте</a>
            </div>
            <div class="map" id="yandex-map"></div>
        </div>
    </div>
    <div class="main_container footer">
        <div>
            <p class="column_name">РАЗДЕЛЫ</p>
            <div class="foot_link" onclick="scrollToElement('Товар')">Товар</div>
            <div class="foot_link" onclick="scrollToElement('Тарифы')">Продукты</div>
            <div class="foot_link" onclick="scrollToElement('Контакты')">Контакты</div>
        </div>
        <div>
            <p class="column_name">ТОВАРЫ</p>
            <div class="foot_link" onclick="document.location='./../diplom/razum'">Разум</div>
            <div class="foot_link" onclick="document.location='./../diplom/criptCloud'">Крипт.Клауд</div>
            <div class="foot_link" onclick="document.location='./../diplom/photoRei'">Фото-Рэй</div>
        </div>
        <div>
            <p class="column_name">ПОЧТА</p>
            <div class="foot_link">vr-it.info@yandex.ru</div>
        </div>
        <div>
            <p class="column_name">КОНТАКТЫ</p>
            <div class="foot_link">Телефон: +7 (995) 668-35-84</div>
            <div class="foot_link">Адрес: шоссе космонавтов, д. 111д,
                подъезд 3, оф. 3</div>
            <a href="https://vk.com/vr_it_ru" class="foot_link" style="text-decoration: underline;">Мы Вконтакте</a>
        </div>
        <div style="display: flex; justify-content: space-around;">
            <a href="https://t.me/ooo_vebrazrabotka"><img class="social_logo" src="img/index_html/tg-icon.svg"></a>
            <a href="https://vk.com/vr_it_ru"><img class="social_logo" src="img/index_html/vk-icon.svg" alt=""></a>
        </div>
    </div>
    <script src="js/razumJs.js"></script>
    <script src="2.1/json.txt?apikey=79acaec8-d0fe-44ae-a71f-d56ef2e3ef7e&lang=ru_RU"></script>
    <script src="js/yanmap.js"></script>
    <script src="js/form/main_form.js"></script>
    <script src="js/form/pop_form.js"></script>
    <script src="js/form/full_popup_vacancy.js"></script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
    ym(93384710, "init", {
         clickmap:true,
         trackLinks:true,
         accurateTrackBounce:true,
         webvisor:true
    });
    </script>
    <noscript><div><img src="watch/93384710" style="position:absolute; left:-9999px;" alt=""></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Google tag (gtag.js) -->
    <script async="" src="gtag/js?id=G-BSKYT19TEP"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-BSKYT19TEP');
    </script>
</body>
</html>
