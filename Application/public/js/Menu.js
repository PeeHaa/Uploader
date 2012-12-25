function Menu() {
    this.menuElement = document.getElementById('header').querySelector('ul.btn-group');

    this.init();
}

Menu.prototype.init = function() {
    if (this.menuElement === null) {
        return;
    }

    var menuItems = this.menuElement.querySelectorAll('a');
    for (var i = 0, l = menuItems.length; i < l; i++) {
        if (menuItems[i].pathname == window.location.pathname) {
            this.deactivateAll();
            this.activateItem(menuItems[i]);
        }
    }
};

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