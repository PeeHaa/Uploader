function Popup() {
    this.activeType = null;
    this.allowClosing = true;

    this.init();
}

Popup.prototype.init = function() {
    if (this.isActive()) {
        var content = this.get().innerHTML;
        this.get().remove();

        this.show('requires-password', content, false);
    }
};

Popup.prototype.isActive = function(type) {
    var popup = this.get();

    if (popup === null || (typeof type !== 'undefined' && this.activeType != type)) {
        return false;
    }

    return true;
};

Popup.prototype.show = function(type, content, allowClosing) {
    this.activeType = type;
    if (typeof allowClosing !== 'undefined') {
        this.allowClosing = allowClosing;
    }

    var body  = document.getElementsByTagName('body')[0],
        popup = document.createElement('div');

    $(document.getElementById('body')).addClass('inactive');
    $(popup).addClass('popup');

    popup.innerHTML = content;
    body.appendChild(popup);

    $(popup).center();

    return popup;
};

Popup.prototype.remove = function(force) {
    var popup = this.get();

    if (popup === null) {
        return;
    }

    if (this.allowClosing === false && (typeof force === 'undefined' || force !== true)) {
        return;
    }

    document.querySelector('body').removeChild(popup);
    $(document.getElementById('body')).removeClass('inactive');
};

Popup.prototype.get = function() {
    return document.querySelector('.popup');
};