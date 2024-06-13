const vacancyForm = document.querySelector('.sendBackVacancyForm'),
    continueBtnSendVacancyForm = vacancyForm.querySelector('.sendBackVacancyForm button'),
    inputAllVacancyForm = vacancyForm.querySelectorAll('.pop_input');

let closeFormVacancyFull = document.querySelector('.full_popup_vacancy');
let closeFormVacancy = document.querySelector('.popup_vacancy');
let doneModalActiveVacancyForm = document.querySelector('.full_thanks');
let errorModalActiveTextVacancyForm = document.querySelector('.text_popup');
let errorModalActiveFullWarningVacancyForm = document.querySelector('.full_warning');
let errorModalActivePopupWarningVacancyForm = document.querySelector('.popup_warning');

vacancyForm.onsubmit = (e) => {
    e.preventDefault();
}

continueBtnSendVacancyForm.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./../php/send_vacancy_form.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                const msg = JSON.parse(data);
                if (data = msg.success) {
                    inputAllVacancyForm.forEach(input => {
                        input.value = '';
                    });
                    closeFormVacancyFull.classList.toggle('active');   
                    closeFormVacancy.classList.toggle('active');   
                    doneModalActiveVacancyForm.classList.toggle('active');
                } else {
                    closeFormVacancyFull.classList.toggle('active');
                    closeFormVacancy.classList.toggle('active');   
                    errorModalActiveTextVacancyForm.innerHTML = msg.message;
                    errorModalActiveFullWarningVacancyForm.classList.toggle('active');
                    errorModalActivePopupWarningVacancyForm.classList.toggle('active');
                }
            }
        }
    }
    let formData = new FormData(vacancyForm);
    xhr.send(formData);
}