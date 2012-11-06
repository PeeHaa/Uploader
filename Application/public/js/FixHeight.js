function FixHeight() {
    this.set();
}

FixHeight.prototype.set = function() {
   var header   = document.getElementsByTagName('header')[0],
       footer   = document.getElementsByTagName('footer')[0],
       body     = document.getElementById('body'),
       dropArea = document.querySelector('.qq-upload-drop-area');

    var remainingHeight = $().getViewport().height - header.offsetHeight - footer.offsetHeight;
    if (remainingHeight > 0) {
        body.style.height = remainingHeight + 'px';

        if (dropArea !== null) {
            dropArea.style.height = remainingHeight + 'px';
        }
    }
};