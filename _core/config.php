<?php
//------ constants
define("CORE_DIR_NAME", '_core/');
define("TPL_DIR_NAME", 'tmp/');
define("PATH", "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
define("PATH_ROOT", $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']);
define("TPL_PATH", "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . CORE_DIR_NAME . TPL_DIR_NAME);
define("PREVIEW_IMG_BASE", "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . CORE_DIR_NAME . 'img/preview.jpg');


class ConfigVar
{
    static public $exception_dirs = ['.', '..', '_core', '_dev', '.git', '.idea'];
}

