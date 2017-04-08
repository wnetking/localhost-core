import tingle from "tingle.js";
import Clipboard from "clipboard";

document.addEventListener("DOMContentLoaded", function () {
    _Core.init();
});

window.createPack = function (projectName, themeName) {
    var http = new XMLHttpRequest(),
        url = config.PATH,
        params = 'project_name=' + projectName + '&theme_name=' + themeName;
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(params);
};


var _Core = (function () {
    var DOM = {},
        CONFIG = {};

    function cashDOM() {
        DOM.indexFixerBtn = document.getElementsByClassName(CONFIG.triggerClass)[0];
        DOM.popUp = document.getElementsByClassName(CONFIG.popUpClass)[0];
        DOM.prijects = document.getElementsByClassName(CONFIG.projectClass);
        DOM.project__helper = document.getElementsByClassName('project__helper');
        DOM.create_git_structure = document.getElementsByClassName('project__create_base_pack');
        DOM.show_details = document.getElementsByClassName('show-details');
        DOM.massage = document.getElementsByClassName('massage');
        DOM.nav = document.getElementsByClassName('nav')[0];
    }

    function cashCONFIG() {
        CONFIG.triggerClass = 'index-fixer';
        CONFIG.popUpClass = 'pop-up';
        CONFIG.projectClass = 'project';
    }

    function openPopUpEvent() {
        DOM.indexFixerBtn.addEventListener('click', function (event) {
            event.preventDefault();
            renderForm();
        });
    }

    function renderForm() {
        var http = new XMLHttpRequest(),
            url = config.PATH_TPL + "index-fixer-form.tpl",
            params = 'index_fixer=true',
            modal = new tingle.modal({
                stickyFooter: false,
                onOpen: function () {
                    var indexForm = document.getElementById('index-fixer');
                    indexForm.setAttribute('action', config.PATH);
                },
                onClose: function () {
                },
                beforeClose: function () {
                    return true;
                }
            });

        function openModal(content) {
            modal.setContent(content);
            modal.open();
        }


        http.open("GET", url, false);
        http.send(params);

        http.status != 200 ? DOM.popUp.innerHTML = 'Sorry, something wrong' : openModal(http.responseText);
    }

    function clipboardInit() {
        var clipboard = new Clipboard('.copy');

        clipboard.on('success', function (e) {
            e.trigger.classList.add('active');
            e.clearSelection();

            setTimeout(function () {
                e.trigger.classList.remove('active');
            }, 2000);
        });
    }

    function removeEl(el) {
        var len = el.length,
            i = 0;
        for (i; i < len; i++) el[i].classList.add('hidden');
    }

    function isNotAdminPage() {
        if (config.isAdminPage) return false;

        removeEl(DOM.project__helper);
        removeEl(DOM.create_git_structure);
        removeEl(DOM.show_details);
    }

    function removeMassage() {
        setTimeout(function () {
            removeEl(DOM.massage);
        }, 3000);
    }

    function navShow() {
        document.addEventListener('mousemove', function (e) {
            if (e.clientY < 50) {
                DOM.nav.classList.add('show');
            } else {
                DOM.nav.classList.remove('show');
            }
        });
    }

    function showProjectDitails() {
        document.addEventListener('click', function (e) {
            if (e.target.classList.item(0) != 'show-details') return;
            var body = '',
                image = e.target.getAttribute('data-image'),
                prName = e.target.getAttribute('data-project-name'),
                themeName = e.target.getAttribute('data-theme-name');

            body += 'show_more=true&image=' + encodeURIComponent(image) +
                '&project_name=' + encodeURIComponent(prName) +
                '&show_theme=' + encodeURIComponent(themeName);

            var modal = new tingle.modal({
                footer: true,
                stickyFooter: true,
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2'],
                onOpen: function () {
                },
                onClose: function () {
                },
                beforeClose: function () {

                    return true; // close the modal
                    return false; // nothing happens
                }
            });

            function openModal(content) {
                modal.setContent(content);
                modal.addFooterBtn('Create Git structure', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function () {
                    var xhr = new XMLHttpRequest(),
                        body = 'create_git=true&project_name_git=' + document.getElementById('project-name-git').innerHTML +
                            '&theme_name_git' + document.getElementById('theme-name-git').innerHTML;
                    xhr.open('POST', config.PATH, true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function () {
                        if (this.readyState != 4) return;
                        modal.close();
                        modal.setContent(this.responseText);
                        modal.setFooterContent('');
                        modal.open();
                    };

                    xhr.send(body);
                });

                modal.addFooterBtn('Clear Data Base', 'tingle-btn tingle-btn--danger', function () {
                    var xhr = new XMLHttpRequest(),
                        body = 'clear_db=' + document.getElementById('data-base').innerHTML;
                    xhr.open('POST', config.PATH, true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function () {
                        if (this.readyState != 4) return;
                        modal.close();
                        modal.setContent(this.responseText);
                        modal.setFooterContent('');
                        modal.open();
                    };

                    xhr.send(body);
                });


                modal.open();
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', config.PATH, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (this.readyState != 4) return;

                openModal(this.responseText);
            };

            xhr.send(body);
        });
    }

    function init() {
        cashCONFIG();
        cashDOM();
        isNotAdminPage();
        clipboardInit();
        openPopUpEvent();
        removeMassage();
        navShow();
        showProjectDitails();
    }

    return {
        init: init
    }
})();