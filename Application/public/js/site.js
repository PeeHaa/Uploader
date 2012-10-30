'use strict';

function isDescendant(parent, child) {
     var node = child.parentNode;
     while (node != null) {
         if (node == parent) {
             return true;
         }
         node = node.parentNode;
     }
     return false;
}

function getViewport() {
    var viewPortWidth,
        viewPortHeight;

    if (typeof window.innerWidth != 'undefined') {
        viewPortWidth = window.innerWidth;
        viewPortHeight = window.innerHeight;
    } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
        viewPortWidth = document.documentElement.clientWidth;
        viewPortHeight = document.documentElement.clientHeight;
    } else {
        viewPortWidth = document.getElementsByTagName('body')[0].clientWidth;
        viewPortHeight = document.getElementsByTagName('body')[0].clientHeight;
    }

    return {width: viewPortWidth, height: viewPortHeight};
}

function showLoginPopup(xhr) {
    var body = document.getElementsByTagName('body')[0],
        bodyContainer = document.getElementById('body'),
        popupContainer = document.createElement('div');

    bodyContainer.className = 'inactive';
    popupContainer.className = 'popup';
    popupContainer.innerHTML = xhr.responseText;
    body.appendChild(popupContainer);

    var loginPopup = body.querySelector('.popup'),
        loginPopupWidth = loginPopup.offsetWidth,
        loginPopupHeight = loginPopup.offsetHeight,
        viewportDimensions = getViewport(),
        leftOffset = (viewportDimensions.width - loginPopupWidth) / 2,
        topOffset = (viewportDimensions.height - loginPopupHeight) / 2;

    if (document.getBoxObjectFor) {
        loginPopup.style.left = leftOffset;
        loginPopup.style.top = topOffset;
    } else {
        loginPopup.style.pixelLeft = leftOffset + document.documentElement.scrollTop;
        loginPopup.style.pixelTop = topOffset + document.documentElement.scrollLeft;
    }

    loginPopup.querySelector('input[name="username"]').focus();
}

function getLoginPopup(e) {
    var e = e || window.event,
        target = e.target || e.srcElement;

    removePopup(e);

    e.preventDefault();
    e.stopPropagation();

    if (target.tagName.toLowerCase() === 'i') {
        target = target.parentNode;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4) {
            return;
        }
        if (xhr.status !== 200) {
            return;
        }
        if (xhr.readyState === 4) {
            showLoginPopup(xhr);
        }
    };

    xhr.open('GET', target.href, true);
    xhr.send();
}

function handleEvents(e)
{
    var e = e || window.event;

    removePopup(e);
}

function removePopup(e) {
    var target = e.target || e.srcElement,
        popup = document.querySelector('.popup');

    if (target == popup || isDescendant(popup, target)) {
        return;
    }

    if (popup !== null) {
        document.querySelector('body').removeChild(popup);
    }
    document.getElementById('body').className = '';
}

function handleSubmits(e) {
    var e = e || window.event,
        target = e.target || e.srcElement;

    e.preventDefault();

    if (target.className == 'login') {
        login(target);
    }
}

function login(loginForm) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4) {
            return;
        }
        if (xhr.status !== 200) {
            return;
        }
        if (xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText),
                username = loginForm.querySelector('input[name="username"]'),
                password = loginForm.querySelector('input[name="password"]');

            if (typeof data.result === 'undefined' || data.result != 'success') {
                username.className = 'error';
                username.blur();
                password.value = '';
                password.className = 'error';
                password.blur();
            } else {
                location.reload(true);
            }
        }
    };

    var postParameters = buildQueryStringBasedOnForm(loginForm);

    xhr.open(loginForm.method, loginForm.action, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(postParameters);
}

function buildQueryStringBasedOnForm(form) {
    var params = [];
    for (var i = 0, length = form.elements.length; i < length; i++) {
        var element = form.elements[i];

        if (element.tagName == 'TEXTAREA') {
            params[element.name] = element.value;
        } else if (element.tagName == 'INPUT') {
            if (element.type == 'text' || element.type == 'hidden' || element.type == 'password') {
                params[element.name] = element.value;
            } else if (element.type == 'radio' && element.checked) {
                if (!element.value) {
                    params[element.name] = 'on';
                } else {
                    params[element.name] = element.value;
                }
            } else if (element.type == 'checkbox' && element.checked) {
                if (!element.value) {
                    params[element.name] = 'on';
                } else {
                    params[element.name] = element.value;
                }
            }
        }
    }

    return buildQueryString(params);
}

function buildQueryString(parameters) {
    var queryString = '',
        delimiter   = '';

    for(var key in parameters) {
        if (!parameters.hasOwnProperty(key)) {
            continue;
        }

        var value = parameters[key];
        queryString += delimiter + encodeURIComponent(key) + '=' + encodeURIComponent(value);

        delimiter = '&';
    }

    return queryString;
}

(function() {
    var header = document.getElementById('header'),
        loginButton = header.querySelectorAll('a.login');

    if (loginButton.length) {
      if (loginButton[0].addEventListener) {
          loginButton[0].addEventListener('click', getLoginPopup);
      } else if (loginButton[0].attachEvent) {
          loginButton[0].attachEvent('onclick', getLoginPopup);
      }
    }

    if (document.addEventListener) {
        document.addEventListener('click', handleEvents);
        document.addEventListener('submit', handleSubmits);
    } else if (document.attachEvent) {
        document.attachEvent('onclick', handleEvents);
        document.attachEvent('onsubmit', handleSubmits);
    }

    if (document.getElementById('file-upload') !== null) {
        var uploader = new qq.FileUploader({
            element: document.getElementById('file-upload'),
            action: '/upload',
            debug: true
        });
    }
}());