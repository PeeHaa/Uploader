function Download() {
}

Download.prototype.verifyPassword = function(form) {
    var formValues = $(form).getFormValues();

    if (!formValues['password']) {
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
                window.location = data.url;
            }
        }
    }.bind(this);

    xhr.open(form.method, form.action + '/json', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(formValues.buildQueryString());
};

Download.prototype.invalidateForm = function(form) {
    var password = form.querySelector('input[name="password"]');

    if (!$(password).hasClass('error')) {
        $(password).addClass('error');
    }

    password.value = '';

    password.blur();
};