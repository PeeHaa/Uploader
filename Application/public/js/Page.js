function Page() {
    this.cachedPages = {};
}

Page.prototype.load = function(type, url, cache) {
    if (this.isCached(type)) {
        this.render(this.cachedPages[type]);

        if (typeof cache === 'undefined' || cache !== true) {
            this.invalidateCache(type);
        }
    } else {
        var xhr = new CustomXMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState < 4 || xhr.status !== 200) {
                return;
            }

            if (xhr.readyState === 4) {
                if (typeof cache !== 'undefined' && cache === true) {
                    this.cache(type, xhr.responseText);
                } else {
                    this.invalidateCache(type);
                }

                this.render(xhr.responseText);
            }
        }.bind(this);
    }

    xhr.open('GET', url, true);
    xhr.send();
};

Page.prototype.isCached = function(type) {
    if(this.cachedPages.hasOwnProperty(type) && this.cachedPages[type] !== null){
        return true;
    }

    return false;
};

Page.prototype.cache = function(type, content) {
    this.cachedPages[type] = content;
};

Page.prototype.invalidateCache = function(type) {
    if (this.isCached(type)) {
        this.cachedPages[type] = null;
    }
};

Page.prototype.getCache = function(type) {
    return this.cachedPages[type];
};

Page.prototype.render = function(content) {
    var body   = document.getElementById('body'),
        footer = body.querySelector('footer'),
        newContent = document.createElement('div');

    var clonedFooter = footer.cloneNode(true);

    body.innerHTML = content;
    body.appendChild(clonedFooter);
};

Page.prototype.clearContents = function(element) {
    while (node.hasChildNodes()) {
        node.removeChild(node.lastChild);
    }
};