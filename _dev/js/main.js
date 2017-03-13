import '../css/main';
window.copy_text = function (self) {
    var copy_text = self.querySelector('.project_copy'),
        range = document.createRange();
    range.selectNode(copy_text);
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
};
window.createPack = function (projectName, themeName) {
    var http = new XMLHttpRequest(),
        url = "/_core/function.php",
        params = 'project_name=' + projectName + '&theme_name=' + themeName;
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(params);
};