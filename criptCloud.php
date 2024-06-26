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
                VALUES (:fioClient, :contact, 3, 1, :dateCreated)";

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
    <title>КРИПТ.КЛАУД | ВР-ИТ.РФ</title>
    <link rel="stylesheet" href="css/criptCloud.css">
    <link rel="stylesheet" href="css/normalize.css">
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
                <a onclick="scrollToElement('Тарифы')">ТАРИФЫ</a>
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
                        <div class="nav_point" onclick="scrollToElement('Тарифы')">ТАРИФЫ</div>
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
            <img class="cloud" src="img/index_html/maskCloud.svg" alt="">
            <div class="sitename">
                <p><l style="color: white; margin-right: 0;">СЕЙФ</l><l style="color: #5CC3FD;">НЕТ</l></p>
            </div>
            <div class="firstdescription">
                <p style="color: white;">
                    РАЗРАБОТКА СРЕДСТВ<br>
                    ЗАЩИТЫ ИНФОРМАЦИИ
                </p>
            </div>
            <div class="orderproject" onclick="scrollToElement('Тарифы')">
                СМОТРЕТЬ ТАРИФЫ
            </div>
        </div>
    </div>
    
    <div class="main_container">
        <div class="divname" id="Товар">
            <p><l style="color: white;">ТОВАР</l></p>
        </div>
        <div class="product">
            <div class="pro_title">
                <p class="pro_name">КРИПТ<l style="color: #5CC3FD; margin-right: 0;">.КЛАУД</l> - ПРОГРАММНОЕ</p>
                <p class="pro_name">ОБЕСПЕЧЕНИЕ ДЛЯ ШИФРОВАНИЯ ДАННЫХ</p>
                <p class="pro_name">ПРИ ЗАГРУЗКЕ В ОБЛАЧНЫЕ ХРАНИЛИЩА</p>
            </div>
            <div class="how_it_work">
                <img class="cub_cript" src="img/index_html/cript_cub.svg" alt="">
                <div class="how_text_content">
                    <p class="p1_how">КАК ЭТО <span style="color: #5CC3FD;">РАБОТАЕТ?</span></p>
                    <p class="p_how">«Крипт<span style="color: #5CC3FD;">.Клауд</span>» автоматически<br>
                        шифрует данные при загрузке в<br>
                        сетевые хранилища, обеспечивая<br>
                        полную защиту от внутренних и<br>
                        внешних утечек информации.</p>
                </div>
            </div>
            <div class="watch_video">
                <div class="watch_video_content">
                    <p class="pro_name">ПОСМОТРИТЕ НАШ ВИДЕОРОЛИК</p>
                    <p class="pro_name">О РАБОТЕ КРИПТ<span style="color: #5CC3FD;">.КЛАУД</span></p>
                </div>
                <iframe width="1110" height="514" src="https://www.youtube.com/embed/Uqbk67QvITw" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="security">
                <div class="security_text_content">
                    <p class="sec_name">ПОЛНАЯ <span style="color: #5CC3FD;">БЕЗОПАСНОСТЬ</span> ВАШИХ ДАННЫХ</p>
                    <p class="p_security">"Крипт<span style="color: #5CC3FD;">.Клауд</span>" защищает данные вашей<br>
                         компании в облаке: в Яндекс.Диск, Mail.ru<br>
                         облако, Dropbox, Google Drive и других.</p>
                </div>
                <img class="locked" src="img/index_html/icon_locked.svg" alt="">
            </div>
            <div class="decision">
                <div class="decision_text_content1">
                    <p class="dec_name">КРИПТ<span style="color: #5CC3FD;">.КЛАУД</span> ИДЕАЛЬНОЕ</p>
                    <p class="dec_name">РЕШЕНИЕ ДЛЯ КРУПНЫХ КОМПАНИЙ</p>
                    <p class="p_decision1">"Крипт<span style="color: #5CC3FD;">.Клауд</span>" прекрасно адаптирован<br>
                        под корпоративное использование<br>
                        в компаниях, где более 50 сотрудников.</p>
                </div>
                <img class="worldwide" src="img/index_html/icon_worldwide.svg" alt="">
            </div>
            <div class="decision_text_content2">
                <p class="p_decision2">Он легко интегрируется с любой<br>
                    операционной системой, облачным<br>
                    хранилищем и службой каталогов.</p>
            </div>
        </div>
        <div class="looktariffs" onclick="scrollToElement('Тарифы')">
            ПЕРЕЙТИ К ТАРИФАМ
        </div>
    </div>
    <div class="main_container">
        <div class="divname" id="Тарифы">
            <p><l style="color: white;">ТАРИФЫ</l></p>
        </div>
        <?php
try {
    // Подключение к базе данных
    require_once 'db_connection.php';
$conn = getConnection();

    // Выполнение запроса к базе данных для продуктов, связанных с проектом 2
    $stmt = $conn->prepare("SELECT [Продукт] FROM [VRITRF].[dbo].[ПродуктыПроекта] WHERE [Проект] = ?");
    $projectId = 3;
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
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">СКОРОСТЬ</p>
                <p class="textasset" style="color: white">Быстрая<br /> скорость работы</p>
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/2</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">ДОВЕРЕННЫЙ АЛГОРИТМ</p>
                <p class="textasset" style="color: white">Российский алгоритм шифрования</p>
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/3</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">АВТОМАТИЗАЦИЯ</p>
                <p class="textasset" style="color: white">Автоматическая<br /> отправка файлов
                    <br />  в облако</p>
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/4</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">ПРОСТОТА</p>
                <p class="textasset" style="color: white">Простота <br />использования</p>
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/5</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">АДАПТИВНОСТЬ</p>
                <p class="textasset" style="color: white">Адаптация под любую операционную систему,
                    <br />
                    облачное хранилище и службу каталогов</p>
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/6</p>
                <p class="nameasset" style="color: #5CC3FD; width: 70%;">ЛЮБОЙ ТИП ФАЙЛОВ</p>
                <p class="textasset" style="color: white">Шифрование любого<br /> типа файлов</p>
            </div>
        </div>
    </div>
    <div class="main_container">
        <div class="divname" id="СтекТехнологий">
            <p style="color: white;"><l style="color: #5CC3FD;">СТЕК </l> РАЗРАБОТКИ</p>
        </div>
        <div class="pro_title">
            <p class="pro_name">ЯЗЫК ПРОГРАММИРОВАНИЯ:<l style="color: #5CC3FD; margin-right: 0;"> C#</l></p>
            <div class="line"></div>
            <p class="pro_name">ФРЕЙМВОРК:<l style="color: #5CC3FD; margin-right: 0;"> .NET FRAMEWORK</l></p>
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

        fetch('php/cript_form.php', {
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
            <div class="foot_link" onclick="scrollToElement('Тарифы')">Тарифы</div>
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
    <script src="js/criptJs.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
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
