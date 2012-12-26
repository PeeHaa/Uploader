function Popup() {
    this.activeType = null;

    this.init();
}

Popup.prototype.init = function() {
    if (this.isActive()) {
        var content = this.get().innerHTML;
        this.get().remove();

        this.show('requires-password', content);
    }
};

Popup.prototype.isActive = function(type) {
    var popup = this.get();

    if (popup === null || (typeof type !== 'undefined' && this.activeType != type)) {
        return false;
    }

    return true;
};

Popup.prototype.show = function(type, content) {
    this.activeType = type;

    var body  = document.getElementsByTagName('body')[0],
        popup = document.createElement('div');

    $(document.getElementById('body')).addClass('inactive');
    $(popup).addClass('popup');

    popup.innerHTML = content;
    body.appendChild(popup);

    $(popup).center();

    return popup;
};

Popup.prototype.remove = function() {
    var popup = this.get();

    if (popup === null) {
        return;
    }

    document.querySelector('body').removeChild(popup);
    $(document.getElementById('body')).removeClass('inactive');
};

Popup.prototype.get = function() {
    return document.querySelector('.popup');
};