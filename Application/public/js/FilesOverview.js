function FilesOverview(page) {
    this.page = page;
}

FilesOverview.prototype.load = function(url) {
    this.page.load('files', url);
};