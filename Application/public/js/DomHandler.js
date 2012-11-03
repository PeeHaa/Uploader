'use strict';

function DomHandler(domElement) {
    this.domElement = domElement;

    return this;
}

DomHandler.prototype.contains = function(childElement) {
     var currentNode = childElement.parentNode;

     while (currentNode != null) {
         if (currentNode == this.domElement) {
             return true;
         }

         currentNode = currentNode.parentNode;
     }

     return false;
};

DomHandler.prototype.containsOrIs = function(childElement) {
    return (this.domElement == childElement || this.contains(childElement));
};

DomHandler.prototype.getViewport = function() {
    if (typeof window.innerWidth != 'undefined') {
        return {
            width: window.innerWidth,
            height: window.innerHeight
        };
    } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
        return {
            width: document.documentElement.clientWidth,
            height: document.documentElement.clientHeight
        };
    } else {
        return {
            width: document.getElementsByTagName('body')[0].clientWidth,
            height: document.getElementsByTagName('body')[0].clientHeight
        };
    }
};

DomHandler.prototype.addClass = function(className) {
    if (this.domElement.className) {
        this.domElement.className + ' ';
    }

    this.domElement.className += className;
};

DomHandler.prototype.removeClass = function(className) {
    var pattern = new RegExp('\\b' + className + '\\b');

    this.domElement.className = this.domElement.className.replace(pattern, '');
};

DomHandler.prototype.hasClass = function(className) {
    var pattern = new RegExp('\\b' + className + '\\b');

    return pattern.test(this.domElement.className);
};

DomHandler.prototype.center = function() {
    var offset = {
        left: (this.getViewport().width - this.domElement.offsetWidth) / 2,
        top: (this.getViewport().height - this.domElement.offsetHeight) / 2
    };

    if (document.getBoxObjectFor) {
        this.domElement.style.left = offset.left;
        this.domElement.style.top = offset.top;
    } else {
        this.domElement.style.pixelLeft = offset.left + document.documentElement.scrollTop;
        this.domElement.style.pixelTop = offset.top + document.documentElement.scrollLeft;
    }
};

DomHandler.prototype.getFormValues = function() {
    var params = [];
    for (var i = 0, length = this.domElement.elements.length; i < length; i++) {
        var element = this.domElement.elements[i];

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

    return params;
};

/**
 * Crossbrowser event handler.
 * Inspired by the eventhandler script created by Martins Teresko (https://github.com/teresko)
 */
DomHandler.prototype.on = function(type, callback) {
    var fix = {
        'focus':    'focusin',
        'blur':     'focusout'
    };

    if (window.addEventListener) {
        this.domElement.addEventListener(type, callback, typeof fix[type] !== undefined);
    } else {
        this.domElement.attachEvent('on' + type, callback);
    }
};

var $ = function(element) {
    return new DomHandler(element);
};