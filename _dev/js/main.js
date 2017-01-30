import '../css/main';
window.copy_text = function (self) {
    var copy_text = self.querySelector('.project_copy');
    var range = document.createRange();
    range.selectNode(copy_text);
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
};
window.createPack = function (projectName, themeName) {
    var http = new XMLHttpRequest();
    var url = "/_core/function.php";
    var params = 'project_name=' + projectName + '&theme_name=' + themeName;
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {
        }
    };
    http.send(params);
};