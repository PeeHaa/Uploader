function Popup() {
    this.activeType = null;
    this.allowClosing = true;

    this.dimensions = {};
    this.resetDimensions();

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

Popup.prototype.setDimensions = function(dimensions) {
    if (typeof dimensions.width !== 'undefined') {
        this.dimensions.width = dimensions.width;
    }

    if (typeof dimensions.height !== 'undefined') {
        this.dimensions.height = dimensions.height;
    }
};

Popup.prototype.resetDimensions = function() {
    this.dimensions = {
        width: null,
        height: null
    };
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
    this.setDimensionsOfPopup(popup);
    body.appendChild(popup);

    $(popup).center();

    return popup;
};

Popup.prototype.setDimensionsOfPopup = function(popup) {
    if (this.dimensions.width !== null) {
        popup.style.width = this.dimensions.width + 'px';
    }

    if (this.dimensions.height !== null) {
        popup.style.height = this.dimensions.height + 'px';
    }

    this.resetDimensions();
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