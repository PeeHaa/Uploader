'use strict';

function Authentication() {

}

Authentication.prototype.showPopup = function(popup, loginButton) {
    if (popup.isActive('login')) {
        return;
    }

    if (popup.isActive()) {
        popup.remove();
    }

    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var popupElement = popup.show('login', xhr.responseText);
            popupElement.querySelector('input[name="username"]').focus();
        }
    };

    xhr.open('GET', loginButton.href + '/json', true);
    xhr.send();
};

Authentication.prototype.login = function(form) {
    var formValues = $(form).getFormValues();

    if (!formValues['username'] || !formValues['password']) {
        return;
    }

    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);

            if (typeof data.result === 'undefined' || data.result != 'success') {
                this.invalidateForm(form);
             } else {
                location.reload(true);
            }
        }
    }.bind(this);

    xhr.open(form.method, form.action, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(formValues.buildQueryString());
};

Authentication.prototype.invalidateForm = function(form) {
    var username = form.querySelector('input[name="username"]'),
        password = form.querySelector('input[name="password"]');

    if (!$(username).hasClass('error')) {
        $(username).addClass('error');
    }
    if (!$(password).hasClass('error')) {
        $(password).addClass('error');
    }

    password.value = '';

    username.blur();
    password.blur();
};