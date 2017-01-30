<?php
if ($_POST['theme_name']) {
    print_r($_POST);
    create_base_pack_theme($_POST['project_name'], $_POST['theme_name']);
};

function create_base_pack_theme($base_dir, $theme_name)
{
    $path_to_theme = $_SERVER['DOCUMENT_ROOT'] . '/' . $base_dir . '/_base_pack/' . $theme_name;
    $config_file = $_SERVER['DOCUMENT_ROOT'] . '/' . $base_dir . '/config/settings.inc.php';
    $structure = [
        'sourse' => [
            'psd',
            'custom_html'
        ],
        'theme' => [
            'manual_install',
            'sample_data',
            'themeinstallator'
        ]
    ];
    foreach ($structure as $key_1 => $value_1) {
        if (!file_exists($path_to_theme . '/' . $key_1)) {
            mkdir($path_to_theme . '/' . $key_1, 0777, true);
            foreach ($value_1 as $key_2 => $value_2) {
                mkdir($path_to_theme . '/' . $key_1 . '/' . $value_2, 0777, true);
            }
        }
    }
    if (file_exists($config_file)) {
        require_once '../' . $base_dir . '/config/settings.inc.php';
        $help_file = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $base_dir . '/_base_pack/' . $theme_name . '/prestashop' . _PS_VERSION_ . '.txt', 'w');
        fwrite($help_file, 'prestashop' . _PS_VERSION_);
        fclose($help_file);
    }
}


function getPreview($url, $theme_name)
{
    $files1 = scandir($url);
    $result = '';
    foreach ($files1 as $key => $value) {
        if ($value == 'themes') {
            $themes = scandir($url . '/themes');
            foreach ($themes as $key2 => $value2) {
                if ($value2 != '.' &&
                    $value2 != '..'
                ) {
                    if (preg_match("/theme/", $value2)) {
                        if (file_exists($url . '/' . $value . '/' . $value2 . '/preview.jpg')) {
                            $result = '';
                            $result .= 'http://' . $_SERVER['SERVER_NAME'] . '/' . $theme_name . '/' . $value . '/' . $value2 . '/preview.jpg';
//                            return $result;
                        }
                    } else {
                        if (file_exists($url . '/' . $value . '/' . $value2 . '/preview.jpg')) {
                            $result .= 'http://' . $_SERVER['SERVER_NAME'] . '/' . $theme_name . '/' . $value . '/' . $value2 . '/preview.jpg';
                        }
                    }
                }
            }
        }
    }
    return $result;
}

function getAdminLink($url, $parent_dir)
{
    $files1 = scandir($url);
    foreach ($files1 as $key => $value) {
        if (preg_match("/admin/", $value)) {
            return 'http://' . $_SERVER['SERVER_NAME'] . '/' . $parent_dir . '/' . $value;
        }
    }
    return 'not_active';
}

function getProjectLink($value)
{
    return 'http://' . $_SERVER['SERVER_NAME'] . '/' . $value;
}

function get_server_link($value)
{
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $value . '/helper.php')) {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/' . $value . '/helper.php';
    } else {
        return 'not_active';
    }
}

function getThemeName($url)
{
    $files1 = scandir($url);
    foreach ($files1 as $key => $value) {
        if ($value == 'themes') {
            $themes = scandir($url . '/themes');
            foreach ($themes as $key2 => $value2) {
                if (preg_match("/theme/", $value2)) {
                    return $value2;
                }

            }
        }
    }
    return 'not_active';
}