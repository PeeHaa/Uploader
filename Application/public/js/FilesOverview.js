function FilesOverview(page) {
    this.page = page;
}

FilesOverview.prototype.load = function(url) {
    this.page.load('files', url);
};

FilesOverview.prototype.showEditPopup = function(popup, url) {
    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var result = JSON.parse(xhr.responseText);
            var popupElement = popup.show('file-info', result.html);
            popupElement.querySelector('input:first-child').focus();
        }
    }.bind(this);

    xhr.open('GET', url + '/json', true);
    xhr.send();
};

FilesOverview.prototype.deleteFile = function() {
    var xhr = new CustomXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState < 4 || xhr.status !== 200) {
            return;
        }

        if (xhr.readyState === 4) {
            var result = JSON.parse(xhr.responseText);

            if (result.result == 'success') {
                var tableRow = $(target.parentNode).closestByTagName('tr');
                $(tableRow).fadeOut(function() {
                    tableRow.parentNode.removeChild(tableRow);
                }, 25);
            } else {
                alert('error!');
            }
        }
    }.bind(this);

    xhr.open('POST', url + '/json', true);
    xhr.send();
};