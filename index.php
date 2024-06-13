﻿<?php
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
                VALUES (:fioClient, :contact, 1, 1, :dateCreated)";

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
    <title>ВНУТРЕННИЕ ПРОЕКТЫ ВР-ИТ.РФ</title>
    <link rel="stylesheet" href="css/mainStyle.css">
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
                <a onclick="scrollToElement('Услуги')">ТОВАРЫ</a>
                <a onclick="scrollToElement('ОКомпании')">О КОМПАНИИ</a>
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
                        <div class="nav_point" onclick="scrollToElement('Главная')">ГЛАВНАЯ</div>
                        <div class="nav_point" onclick="scrollToElement('Услуги')">ТОВАРЫ</div>
                        <div class="nav_point" onclick="scrollToElement('ОКомпании')">О КОМПАНИИ</div>
                        <div class="nav_point" onclick="scrollToElement('ОтветыНаВопросы')">ОТВЕТЫ НА ВОПРОСЫ</div>
                        <div class="nav_point" onclick="scrollToElement('Контакты')">КОНТАКТЫ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="head_container">
        <div class="sitename">
            <p><l style="color: #5CC3FD; margin-right: 0;">ВР</l><l style="color: white;">-ИТ.РФ</l></p>
        </div>
        <div class="firstdescription">
            <p style="color: white;">
                НАШИ ВНУТРЕННИЕ ПРОЕКТЫ:<br>
                <l style="color: #5CC3FD; margin-right: 0;">КРИПТ</l>.КЛАУД, <l style="color: #5CC3FD; margin-right: 0;">РАЗУМ</l>, <l style="color: #5CC3FD; margin-right: 0;">ФОТО</l>-РЭЙ
            </p>
        </div>
        <div class="orderproject" onclick="scrollToElement('Услуги')">
            СМОТРЕТЬ ТОВАРЫ
        </div>
    </div>

    <div class="main_container">
        <div class="divname" id="Услуги">
            <p><l style="color: white;">НАШИ</l> <l style="color: #5CC3FD;">ТОВАРЫ</l></p>
        </div>
        <div class="cards">
            <div class="card first" onclick="document.location='./../diplom/razum'">
            </div>
            <div class="card_content">
                <p class="card_text" style="cursor: pointer;"  onclick="redirectToPage('./../diplom/razum')">
                    РАЗУМ&nbsp; <img class="arra" src="img/index_html/Arrow.svg" alt="" onclick="document.location='./../diplom/razum'" style="cursor: pointer;"></p>
                <p class="card_info">Автопилот 6-го поколения<br>без интернета и GPS</p>
            </div>
            <div class="card second" onclick="document.location='./../diplom/criptCloud'">
            </div>
            <div class="card_content">
                <p class="card_text" style="cursor: pointer;" onclick="redirectToPage('./../diplom/criptCloud')">
                    КРИПТ.КЛАУД&nbsp; <img class="arra" src="img/index_html/Arrow.svg" alt="" onclick="document.location='./../diplom/criptCloud'" style="cursor: pointer;"></p>
                <p class="card_info2">ПО для автоматического<br>шифрования данных</p>
            </div>
            <div class="card third" onclick="document.location='./../diplom/photoRei'">
            </div>
            <div class="card_content">
                <p class="card_text " style="cursor: pointer;" onclick="redirectToPage('./../diplom/photoRei')">
                    ФОТО-РЭЙ&nbsp; <img class="arra" src="img/index_html/Arrow.svg" alt="" onclick="document.location='./../diplom/photoRei'" style="cursor: pointer;"></p>
                <p class="card_info3">Интернет будущего</p>
            </div>
        </div>
    </div>
    <script>
        function redirectToPage(url) {
            window.location.href = url;
        }
    </script>
    
    
    <div class="main_container">
        <div class="divname" id="ОКомпании">
            <p><l style="color: #5CC3FD;">О </l><l style="color: #fff;"> КОМПАНИИ</l></p>
        </div>
        <div class="philosophy1">
            <div class="nameone">
                <div style="display: flex;">
                    <l style="color: white;">НАША </l>
                    <img src="img/index_html/Vector%2036.svg" alt="" style="margin-left: 10px;">
                </div>
                <l style="color: #5CC3FD;"> ФИЛОСОФИЯ</l>
                
            </div>
            <p class="m_phhilosofy"><l style="color: white;">НАША </l><l style="color: #5CC3FD;"> ФИЛОСОФИЯ</l></p>
            <div class="philtext">
                <l style="color: white;">Философия нашей компании заключается</l>
                <l style="color: #5CC3FD;">в стремлении создать лучшее</l>
                <l style="color: #5CC3FD;">отечественное программное обеспечение,</l>
                <l style="color: #5CC3FD;">независимое от западных решений,</l>
                <l style="color: white;">постоянно развивающиеся и</l>
                <l style="color: white;">предоставляющие нашим гражданам</l>
                <l style="color: white;">полезные и значимые решения.</l>
            </div>
            <img src="img/index_html/image%201.png" alt="">
        </div>
        <div class="morebtn2">
            <a onclick="morephilosofy()">Подробнее</a>
        </div>
        <div class="philosophy2">
            <img src="img/index_html/image%202.svg" alt="" style="margin-right: 50px;">
            <div>
                <div class="nameone">
                    <div style="display: flex;">
                        <p style="color: white;">НАША</p>
                        <img src="img/index_html/Vector%2036.svg" alt="" style="margin-left: 10px;">
                    </div>
                    <p style="color: #5CC3FD;">ФИЛОСОФИЯ</p>  
                </div>
                <div class="philtext">
                    <p style="color: white;">Мы стремимся к непрерывному росту и инновациям,
                        разрабатывая продукты, улучшающие качество жизни
                        пользователей и способствующие экономическому
                        прогрессу России. <l style="color: #5CC3FD;  font-style: normal;">Мы ставим перед собой цель стать
                        лидером в сфере разработки отечественного ПО, обеспечивая
                        независимость нашей страны от инностранных IT-решений</l>
                    </p>
                </div> 
            </div>  
        </div>
        <div class="mission">
            <p class="m_phhilosofy"><l style="color: white;">НАША </l><l style="color: #5CC3FD;"> МИССИЯ</l></p>
            <div class="mission_text">   
                <div class="nameone">
                    <div style="display: flex;">
                        <p style="color: white;">НАША</p>
                        <img src="img/index_html/Vector%2036.svg" alt="" style="margin-left: 10px;">
                    </div>
                    <p style="color: #5CC3FD;">МИССИЯ</p>
                </div>
                <div class="philtext">
                    <p style="color: white;">Наша миссия - 
                        <l style="color: #5CC3FD; font-style: normal;">
                        обеспечить доступ к качественному, надежному и значимому программному обеспечению для граждан РФ.
                        </l>
                        <l>
                            Мы стремимся к созданию продуктов, которые упрощают жизнь людей, делают ее более комфортной и безопасной
                        </l>
                    </p>
                </div>  
            </div>
            <img src="img/index_html/image%203.png">

        </div>

        <div class="awards">
            <p class="m_phhilosofy"><l style="color: white;">НАШИ </l><l style="color: #5CC3FD;"> НАГРАДЫ</l></p>
            <div class="nameone">
                <div style="display: flex;">
                    <p style="color: white;">НАШИ <l style="color: #5CC3FD;">НАГРАДЫ</l></p>
                    <img src="img/index_html/Vector%2036.svg" alt="" style="margin-left: 10px;">
                </div>
            </div>
            <div class="aboutawards">
                <div>
                    <p class="headgriddiv">Лучшая ИТ-компания</p>
                    <p class="griddivtext">
                        Стали <l style="color: #5CC3FD;">лучшей ИТ-компанией</l> по
                    </p>
                    <p class="griddivtext">
                        версии Цифровой Долины Прикамья
                    </p>
                </div>
                <div>
                    <p class="headgriddiv">Победители акселераторов</p>
                    <p class="griddivtext"><l style="color: #5CC3FD;">Победители</l>
                    акселераторов с</p>
                    <p class="griddivtext">собственными проектами:</p>
                    <ul class="griddivtext centr">
                        <li><l style="color: #5CC3FD;">"РАЗУМ"</l> - автопилот 6-го поколения без интернета и GPS</li>
                        <li><l style="color: #5CC3FD;">"Крипт.Клауд"</l> - ПО для автоматического шифрования данных</li>
                        <li><l style="color: #5CC3FD;">"ФОТО-РЭЙ"</l> - Интернет будущего</li>
                    </ul>
                </div>
                <div>
                    <p class="headgriddiv">Проекты в ТОП-100</p>
                    <p class="griddivtext">
                        Внутренние проекты компании входят в <l style="color: #5CC3FD;">ТОП-100</l> лучших проектов форума
                        "Сильные идеи для нового времени"
                    </p>
                </div>
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

        fetch('php/handle_form.php', {
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
            <div class="foot_link" onclick="scrollToElement('Главная')">Товары</div>
            <div class="foot_link" onclick="scrollToElement('ОКомпании')">О компании</div>
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
    <script src="js/mainJs.js"></script>
    <script src="js/mainSumbit.js"></script>
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
