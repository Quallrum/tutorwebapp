'use strict';

let arrayOfRadioButtons = document.querySelectorAll('.chooseGroup__input');

for (let i = 0; i < arrayOfRadioButtons.length; i++) {
    arrayOfRadioButtons[i].addEventListener('change', sendAjaxChooseGroupForm);
}

function sendAjaxChooseGroupForm() {
    let form = document.forms['chooseGroup'];
    let formData = new FormData(form);
    let action = form.getAttribute('action');
    let xhr = new XMLHttpRequest();

    try {

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status == 200) {
                    let arrayJSON = JSON.parse(xhr.responseText);
                    let linkToRedirect = arrayJSON.link;
                    if (linkToRedirect) {
                        window.location.href = linkToRedirect;
                    } else {
                        throw new Error('cant find link');
                    }
                } else {
                    document.getElementById('chooseAlert').style.display = 'block';
                }
            }
        }

        xhr.open('POST', action);
        xhr.send(formData);

    } catch (e) {
        console.log(e);
    }
}

document.getElementById('chooseAlertCross').addEventListener('click', function () {
    document.getElementById('chooseAlert').style.display = 'none';
});