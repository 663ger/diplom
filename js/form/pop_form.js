const popForm = document.querySelector('.sendBackPopForm'),
    continueBtnSendPopForm = popForm.querySelector('.sendBackPopForm button'),
    inputAllPopForm = popForm.querySelectorAll('.pop_input');

let closeForm = document.querySelector('.full_popup_backcall');
let doneModalActivePopForm = document.querySelector('.full_thanks');
let errorModalActiveTextPopForm = document.querySelector('.text_popup');
let errorModalActiveFullWarningPopForm = document.querySelector('.full_warning');
let errorModalActivePopupWarningPopForm = document.querySelector('.popup_warning');

popForm.onsubmit = (e) => {
    e.preventDefault();
}

continueBtnSendPopForm.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./../php/send_pop_form.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                const msg = JSON.parse(data);
                if (data = msg.success) {
                    inputAllPopForm.forEach(input => {
                        input.value = '';
                    });
                    closeForm.classList.toggle('active');   
                    doneModalActivePopForm.classList.toggle('active');
                } else {
                    closeForm.classList.toggle('active');
                    errorModalActiveTextPopForm.innerHTML = msg.message;
                    errorModalActiveFullWarningPopForm.classList.toggle('active');
                    errorModalActivePopupWarningPopForm.classList.toggle('active');
                }
            }
        }
    }
    let formData = new FormData(popForm);
    xhr.send(formData);
}