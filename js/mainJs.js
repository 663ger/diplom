function readmore1() {
    let callone = document.getElementById('one');
    if (callone.innerHTML === "+"){
        callone.innerHTML ="-";
    }
    else callone.innerHTML = "+";
    document.querySelector('.textone').classList.toggle('active');
}
function readmore2() {
    let calltwo = document.getElementById('two');
    if (calltwo.innerHTML === "+"){
        calltwo.innerHTML ="-";
    }
    else calltwo.innerHTML = "+";
    document.querySelector('.texttwo').classList.toggle('active');
}
function readmore3() {
    let callthree = document.getElementById('three');
    if (callthree.innerHTML === "+"){
        callthree.innerHTML ="-";
    }
    else callthree.innerHTML = "+";
    document.querySelector('.textthree').classList.toggle('active');
}
function readmore4() {
    let callfour = document.getElementById('four');
    if (callfour.innerHTML === "+"){
        callfour.innerHTML ="-";
    }
    else callfour.innerHTML = "+";
    document.querySelector('.textfour').classList.toggle('active');
}
function readmore5() {
    let callfour = document.getElementById('five');
    if (callfour.innerHTML === "+"){
        callfour.innerHTML ="-";
    }
    else callfour.innerHTML = "+";
    document.querySelector('.textfive').classList.toggle('active');
}
function morephilosofy() {
    document.querySelector('.morebtn2').classList.toggle('none');
    document.querySelector('.philosophy2').classList.toggle('active');
    document.querySelector('.mission').classList.toggle('active'); 

}
function navopen(){
    document.querySelector('.nav').classList.toggle('active');
}
function backcall(){
    document.querySelector('.full_popup_backcall').classList.toggle('active');
    document.querySelector('.popup_backcall').classList.toggle('active');
}
document.addEventListener('DOMContentLoaded', function() {
    const popButton = document.querySelector('.pop_button');
    popButton.addEventListener('click', function(event) {
        event.preventDefault(); // предотвращаем отправку формы по умолчанию
        const fioClientInput = document.querySelector('input[name="fioClient"]');
        const contactInput = document.querySelector('input[name="contact"]');
        
        if (fioClientInput.value.trim() === '' || contactInput.value.trim() === '') {
            openWarning('Заполните все поля');
        } else if (!isValidPhoneNumber(contactInput.value.trim()) && !isValidEmail(contactInput.value.trim())) {
            openWarning('Введите корректный номер телефона или email');
        } else {
            const formData = new FormData();
            formData.append('fioClient', fioClientInput.value.trim());
            formData.append('contact', contactInput.value.trim());
            
            // Отправка данных на сервер
            sendData(formData);
        }
    });
});

function sendData(formData) {
    // Проверка наличия данных перед отправкой на сервер
    if (formData.get('fioClient') === '' || formData.get('contact') === '') {
        openWarning('Заполните все поля');
        return; // Прекращаем выполнение функции, если есть пустые поля
    }
    
    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            showThanksPopup();
            clearFormFields();
        } else {
            throw new Error('Произошла ошибка при отправке данных');
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        openWarning('Произошла ошибка при отправке данных');
    });
}


function openWarning(message) {
    const warningText = document.querySelector('.text_popup');
    warningText.textContent = message;
    document.querySelector('.full_popup_backcall').classList.toggle('active');
    document.querySelector('.popup_backcall').classList.toggle('active');
    document.querySelector('.full_warning').classList.add('active');
    document.querySelector('.popup_warning').classList.add('active');
}

function closeWarning() {
    document.querySelector('.full_warning').classList.remove('active');
    document.querySelector('.popup_warning').classList.remove('active');
}

function showThanksPopup() {
    document.querySelector('.full_popup_backcall').classList.toggle('active');
    document.querySelector('.popup_backcall').classList.toggle('active');
    document.querySelector('.full_thanks').classList.add('active');
    document.querySelector('.popup_thanks').classList.add('active');
}

function closeThanks() {
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

function clearFormFields() {
    document.querySelector('input[name="fioClient"]').value = '';
    document.querySelector('input[name="contact"]').value = '';
}

function scrollToElement(id) {
    var element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
    }
}
function vacancy(){
    document.querySelector('.full_popup_vacancy').classList.toggle('active');
    document.querySelector('.popup_vacancy').classList.toggle('active');
}