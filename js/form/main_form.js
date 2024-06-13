const mainForm = document.querySelector('.main_form'),
    continueBtnSend = mainForm.querySelector('.main_form button'),
    inputAll = mainForm.querySelectorAll('.quest_input');

let doneModalActive = document.querySelector('.full_thanks');
let errorModalActiveText = document.querySelector('.text_popup');
let errorModalActiveFullWarning = document.querySelector('.full_warning');
let errorModalActivePopupWarning = document.querySelector('.popup_warning');

mainForm.onsubmit = (e) => {
    e.preventDefault();
}

continueBtnSend.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./../php/send_main_form.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                const msg = JSON.parse(data);
                if (data = msg.success) {
                    inputAll.forEach(input => {
                        input.value = '';
                    });
                    doneModalActive.classList.toggle('active');
                } else {
                    errorModalActiveText.innerHTML = msg.message;
                    errorModalActiveFullWarning.classList.toggle('active');
                    errorModalActivePopupWarning.classList.toggle('active');
                }
                
            }
        }
    }
    let formData = new FormData(mainForm);
    xhr.send(formData);
}