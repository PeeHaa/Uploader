function FilesOverview(page) {
    this.page = page;
}

FilesOverview.prototype.load = function(url) {
    this.page.load('files', url);
};

FilesOverview.prototype.showEditPopup = function(popup, url) {
    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var result = JSON.parse(xhr.responseText);
            var popupElement = popup.show('file-info', result.html);
            popupElement.querySelector('input:first-child').focus();

            var accessSelect = popupElement.getElementsByTagName('select')[0];

            $(accessSelect).on('change', function() {
                var table = $(accessSelect).closestByTagName('table');

                if (accessSelect.value == 'password') {
                    this.setDisplay(table.querySelectorAll('.password'), 'table-row');
                } else {
                    this.setDisplay(table.querySelectorAll('.password'), 'none');
                }
            }.bind(this));

            var editForm = popupElement.getElementsByTagName('form')[0];
            $(editForm).on('submit', function(e) {
                this.edit(editForm, popup);

                e.preventDefault();
                e.stopPropagation();
            }.bind(this));
        }
    }.bind(this);

    xhr.open('GET', url + '/json', true);
    xhr.send();
};

FilesOverview.prototype.setDisplay = function(domElements, value) {
    for (var i = 0, l = domElements.length; i < l; i++) {
        domElements[i].style.display = value;
    }
};

FilesOverview.prototype.edit = function(form, popup) {
    var formValues = $(form).getFormValues();

    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);

            if (typeof data.errors === 'undefined' || data.errors.length) {
                this.invalidateForm(form, data.errors);
            } else {
                this.updateView(form);
                popup.remove();
            }
        }
    }.bind(this);

    xhr.open(form.method, form.action + '/json', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(formValues.buildQueryString());
};

FilesOverview.prototype.invalidateForm = function(form, errors) {
    var password  = form.querySelector('input[name="password"]'),
        password2 = form.querySelector('input[name="password2"]');

    if (errors.indexOf('password') != -1 && !$(password).hasClass('error')) {
        $(password).addClass('error');
    }

    if (errors.indexOf('password2') != -1 && !$(password2).hasClass('error')) {
        $(password2).addClass('error');
    }

    password.value = '';
    password2.value = '';

    password.blur();
    password2.blur();
};

FilesOverview.prototype.updateView = function(form) {
    var name        = form.querySelector('[name=name]').value,
        description = form.querySelector('[name=description]').value,
        access      = form.querySelector('[name=access]').options[form.querySelector('[name=access]').selectedIndex].text,
        id          = form.querySelector('[name=id]').value;

    var row = document.querySelector('tr[data-id="' + id + '"]');

    row.querySelector('.name').innerText = name;
    row.querySelector('.description').innerText = description;
    row.querySelector('.access').innerText = access;
};

FilesOverview.prototype.deleteFile = function() {
    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var result = JSON.parse(xhr.responseText);

            if (result.result == 'success') {
                var tableRow = $(target.parentNode).closestByTagName('tr');
                $(tableRow).fadeOut(function() {
                    tableRow.parentNode.removeChild(tableRow);
                }, 25);
            } else {
                alert('error!');
            }
        }
    }.bind(this);

    xhr.open('POST', url + '/json', true);
    xhr.send();
};