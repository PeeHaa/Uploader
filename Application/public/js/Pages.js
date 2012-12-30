function Pages(popup) {
    this.popup = popup;
}

Pages.prototype.load = function(url) {
    if (this.popup.isActive()) {
        this.popup.remove();
    }

    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var jsonResponse = JSON.parse(xhr.responseText);

            this.popup.show('page', jsonResponse.html);
        }
    }.bind(this);

    xhr.open('GET', url + '/json', true);
    xhr.send();
};