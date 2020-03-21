'use strict';

function checkEmail(str) {
    str = str.toString();
    var regExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (regExp.test(str)) {
        return true;
    } else {
        return false;
    }
}

document.getElementById('forgetPasswordInput').addEventListener('input', function () {
    let value = this.value;
    let submitButton = document.querySelector('.forgetPassword__submit');
    if (checkEmail(value)) {
        submitButton.style.background = '#f9e547';
    } else {
        submitButton.style.background = '#fdf7cb';
    }
});

let form = document.forms['forgetPassword'];
form.addEventListener('submit', function (e) {
    e.preventDefault();
    let email = document.getElementById('forgetPasswordInput').value;
    if (checkEmail(email)) {
        sendAjaxForgetPassword();
    } else {
        putTextInAlertAndShowIt('Заполните это поле');
        setTimeout(() => {
            document.getElementById('alertCross').click();
        }, 2000)
    }

});

function sendAjaxForgetPassword() {
    let formData = new FormData(form);
    let action = form.getAttribute('action');
    let xhr = new XMLHttpRequest();

    try {

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status == 200) {
                    putTextInSuccessAlertAndShowIt('Успешно отправлено');
                } else {
                    putTextInAlertAndShowIt('Упс, что-то пошло не так(');
                }
            }
        }


        xhr.open('POST', action);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.send(formData);

    } catch (e) {
        console.log(e);
    }
}
