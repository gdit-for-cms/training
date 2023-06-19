(function() {
    var css = document.createElement('link');
    css.href = 'https://use.fontawesome.com/releases/v6.2.0/css/all.css';
    css.rel = 'stylesheet';
    css.type = 'text/css';
    var js = document.createElement('script');
    js.src = "/ckeditor5-build-classic/ckeditor.js"
    headElement = document.getElementsByTagName('head')[0]
    headElement.appendChild(css);
    headElement.appendChild(js);
})();