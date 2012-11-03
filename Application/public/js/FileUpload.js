function FileUpload() {
    this.popup          = new Popup();
    this.authentication = new Authentication();

    this.initializeEventListeners();
}

FileUpload.prototype.initializeEventListeners = function() {
    this.addOnClickListeners();
    this.addOnSubmitListeners();
};

FileUpload.prototype.addOnClickListeners = function() {
    $(document).on('click', function(e) {
        var e           = e || window.event,
            target      = e.target || e.srcElement,
            header      = document.getElementById('header'),
            loginButton = header.querySelector('a.login');

        // handle login
        if (loginButton !== null && $(loginButton).containsOrIs(target)) {
            this.authentication.showPopup(this.popup, loginButton);

            e.preventDefault();
            e.stopPropagation();

            return;
        }

        // remove popup when clicked on document somewhere
        if (this.popup.isActive && !$(this.popup.get()).containsOrIs(target)) {
            this.popup.remove();
        }
    }.bind(this));
};

FileUpload.prototype.addOnSubmitListeners = function() {
    $(document).on('submit', function() {
        var e      = e || window.event,
            target = e.target || e.srcElement;

        // handle login
        if ($(target).hasClass('login')) {
            this.authentication.login(target);

            e.preventDefault();
            e.stopPropagation();

            return;
        }

    }.bind(this));
};