function Menu() {
    var header = document.getElementById('header');

    this.menuElement = header.querySelector('ul.btn-group');
}

Menu.prototype.deactivateAll = function() {
    var elements = this.menuElement.querySelectorAll('li');

    for (var i = 0, length = elements.length; i < length; i++) {
        $(elements[i]).removeClass('active');
    }
}

Menu.prototype.activateItem = function(target) {
    var elements = this.menuElement.querySelectorAll('li');

    for (var i = 0, length = elements.length; i < length; i++) {
        if ($(elements[i]).containsOrIs(target)) {
            $(elements[i]).addClass('active');
        }
    }
};