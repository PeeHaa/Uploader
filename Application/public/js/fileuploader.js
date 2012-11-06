function FileUploader() {
    function enableFileUploader() {
        var uploadElement = document.getElementById('file-upload');
        if (uploadElement === null) {
            return;
        }

        var uploader = new qq.FileUploader({
            element: uploadElement,
            action: '/upload'
        });
    }

    enableFileUploader();

    this.popup          = new Popup();
    this.authentication = new Authentication();
    this.fixHeight      = new FixHeight();

    this.initializeEventListeners();
}

FileUploader.prototype.initializeEventListeners = function() {
    this.addOnClickListeners();
    this.addOnSubmitListeners();
    this.addOnResizeListeners();
};

FileUploader.prototype.addOnClickListeners = function() {
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

FileUploader.prototype.addOnSubmitListeners = function() {
    $(document).on('submit', function(e) {
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

FileUploader.prototype.addOnResizeListeners = function() {
    $(window).on('resize', function(e) {
        this.fixHeight.set();
    }.bind(this));
};