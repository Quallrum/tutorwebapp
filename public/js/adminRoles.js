'use strict';

let form = document.forms['adminRolesForm'];

form.addEventListener('submit', (e) => { e.preventDefault(); });

let arrayOfSelect = document.querySelectorAll('.adminRoles__select');
for (let i = 0; i < arrayOfSelect.length; i++) {
    arrayOfSelect[i].addEventListener('change', sendAjaxWithRole);
}

function sendAjaxWithRole(e) {
    let selectElem = e.target;
    let userId = e.target.parentNode.getAttribute('data-id');

    let formData = new FormData();
    formData.append('user', userId);
    formData.append('role', selectElem.value);

    let action = form.getAttribute('action');

    let xhr = new XMLHttpRequest();

    try {
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status == 200) {
                    putTextInSuccessAlertAndShowIt('Данные успешно обновлены');
                } else {
                    try {
                        let arrayJSON = JSON.parse(xhr.responseText);
                        let errors = arrayJSON.errors;

                        let strWithError = '';
                        for (let error in errors) {
                            strWithError += error + '\n';
                        }

                        putTextInAlertAndShowIt(strWithError);
                    } catch (e) {
                        putTextInAlertAndShowIt('Упс, что-то пошло не так(');
                    }
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