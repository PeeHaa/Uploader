Array.prototype.buildQueryString = function() {
    var queryString = '',
        delimiter   = '';

    for(var key in this) {
        if (!this.hasOwnProperty(key)) {
            continue;
        }

        queryString += delimiter + encodeURIComponent(key) + '=' + encodeURIComponent(this[key]);

        delimiter = '&';
    }

    return queryString;
};