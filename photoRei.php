
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
                VALUES (:fioClient, :contact, 4, 1, :dateCreated)";

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
    <title>ФОТО-РЕЙ | ВР-ИТ.РФ</title>
    <link rel="stylesheet" href="css/photoRei.css">
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
                <p><l style="color: white; margin-right: 0;">ФОТО-</l><l style="color: #5CC3FD;">РЭЙ</l></p>
            </div>
            <div class="firstdescription">
                <p style="color: white;">
                    ИНТЕРНЕТ БУДУЩЕГО
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
                <p class="pro_name">ФОТО-<l style="color: #5CC3FD; margin-right: 0;">РЕЙ</l> - ЭТО АППАРАТНО-ПРОГРАММНЫЙ</p>
                <p class="pro_name">КОМПЛЕКС ДЛЯ ЗАЩИЩЕННОЙ ОПТИЧЕСКОЙ,</p>
                <p class="pro_name">БЕСПРОВОДНОЙ ПЕРЕДАЧИ ДАННЫХ С</p>
                <p class="pro_name">ВЫСОКОЙ СКОРОСТЬЮ</p>
            </div>
            <div class="loading">
                <div class="load_low">
                    <img class="img_Wi_fi" src="img/index_html/Wi-Fi.svg" alt="">
                    <img class="snail1" src="img/index_html/snail.svg" alt="">
                    <img class="" src="img/index_html/load_low.svg" alt="">
                    <img class="Download" src="img/index_html/Download.svg" alt="">
                </div>
                <div class="load_fast">
                    <img class="img_Photo_Rei" src="img/index_html/Photo-Rei.svg" alt="">
                    <img class="snail2" src="img/index_html/snail.svg" alt="">
                    <img class="" src="img/index_html/load_fast.svg" alt="">
                    <img class="Download" src="img/index_html/Download.svg" alt="">
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
            require_once 'db_connection.php';
            $conn = getConnection();
    // Выполнение запроса к базе данных для продуктов, связанных с проектом 2
    $stmt = $conn->prepare("SELECT [Продукт] FROM [VRITRF].[dbo].[ПродуктыПроекта] WHERE [Проект] = ?");
    $projectId = 4;
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
        echo '<div class="div2">' . $productInfo['Название'] . '</div>';
        echo '<div class="">' . $productInfo['Цена'] . '</div>';
        echo '<div class="_1-12">' . $productInfo['Описание'] . '</div>';
        // Вывод названия статуса продукта на кнопке
        echo '<div class="buytariff2" onclick="backcall()">' . $statusInfo['Название'] . '</div>';
        echo '<div class="boxtarrif2"></div>';
        echo '</div>';
    }
    } catch (PDOException $e) {
        echo "Ошибка подключения к базе данных: " . $e->getMessage();
    }
    ?>
        <div class="indent"></div>
    </div>

    <div class="main_container">
        <div class="divname" id="Преимущества">
            <p style="color: white;">ПРЕИМУЩЕСТВА</p>
        </div>
        <div class="assets">
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/1</p>
                <p class="textasset" style="color: white">Высокая скорость<br>передачи данных<br>(До 5 Гбит/сек.)</p>
                <img class="deadline" src="img/index_html/icon-deadline.svg" alt="">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/2</p>
                <p class="textasset2" style="color: white">Безопасная передача<br>данных</p>
                <img class="protection" src="img/index_html/icon-protection.svg" alt="">
            </div>
            <div class="asset nl">
                <p class="numasset" style="color: #5CC3FD;">/3</p>
                <p class="textasset3" style="color: white">Не подвержено<br>влиянию помех от
                    <br>радиосигналов</p>
                    <img class="wireless-router" src="img/index_html/icon-wireless-router.svg" alt="">
            </div>
        </div>
    </div>
    <div class="main_container">
        <div class="divname_obl" id="СтекТехнологий">
            <p style="color: white;">ОБЛАСТИ <l style="color: #5CC3FD;">ПРИМЕНЕНИЯ</l></p>
        </div>
        <div class="integration">
            <div class="integration_content">
                <div class="int_img">
                <img class="" src="img/index_html/military.svg" alt="">
                <img class="" src="img/index_html/warship.svg" alt="">
                <img class="" src="img/index_html/iskusstvennii-intellekt.svg" alt="">
                <img class="" src="img/index_html/information-security.svg" alt="">
                </div>
                <div class="int_p">
                    <p class="p_int1">Военная промышленность</p>
                    <p class="p_int2">Подводная связь</p>
                    <p class="p_int3">Интернет вещей</p>
                    <p class="p_int4">Информационная<br>безопасность</p>
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

        fetch('php/photoRei_form.php', {
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
    <script src="js/photoReiJs.js"></script>
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
