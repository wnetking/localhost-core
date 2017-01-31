<?php
$structure = [];

// ----- base array elements ------- //
$preview = 'preview';
$admin_link = 'admin';
$project_link = 'project_link';
$project_name = 'project_name';
$helper_link = 'helper_link';
$theme_name = 'theme_name';

require_once 'function.php';
require_once 'templateCore.php';

// ----- help variables -------//
$preview_img_base = './_core/img/preview.jpg';
$templater = new Templater();
$dir = $_SERVER['DOCUMENT_ROOT'] . '/';
$files1 = scandir($dir);

foreach ($files1 as $key => $value) {
    if ($files1[$key] != '.' &&
        $files1[$key] != '..' &&
        $files1[$key] != '_core' &&
        $files1[$key] != '_dev' &&
        $files1[$key] != '.idea' &&
        $files1[$key] != '.git' &&
        is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . $value)
    ) {
        if (getPreview($_SERVER['DOCUMENT_ROOT'] . '/' . $value, $value)) {
            $structure[$value][$preview] = getPreview($_SERVER['DOCUMENT_ROOT'] . '/' . $value, $value);
        } else {
            $structure[$value][$preview] = $preview_img_base;
        }
        $structure[$value][$project_name] = $value;
        $structure[$value][$admin_link] = getAdminLink($_SERVER['DOCUMENT_ROOT'] . '/' . $value, $value);
        $structure[$value][$project_link] = getProjectLink($value);
        $structure[$value][$helper_link] = get_server_link($value);
        $structure[$value][$theme_name] = getThemeName($_SERVER['DOCUMENT_ROOT'] . '/' . $value);
    }
}

foreach ($structure as $key => $value) {
    print $templater->tmp($value, 'template.tpl');
}