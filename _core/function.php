<?php


class Functions
{
    static public function create_base_pack_theme($base_dir, $theme_name)
    {
        $folder_name = '_FORGIT';
        $path_to_theme = PATH_ROOT . $base_dir . '/' . $folder_name . '/' . $theme_name;
        $config_file = PATH_ROOT . $base_dir . '/config/settings.inc.php';
        $structure = [
            'sources' => [
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
            require_once PATH_ROOT . $base_dir . '/config/settings.inc.php';
            fopen(PATH_ROOT . $base_dir . '/' . $folder_name . '/' . $theme_name . '/prestashop_' . _PS_VERSION_ . '.txt', 'w');
        }

        echo '<h1>Structure create, check  project <em>' . $base_dir . '</em> folder.</h1>';
        exit;
    }


    static public function getPreview($url, $theme_name)
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
                                $result .= PATH . $theme_name . '/' . $value . '/' . $value2 . '/preview.jpg';
                            }
                        } else {
                            if (file_exists($url . '/' . $value . '/' . $value2 . '/preview.jpg')) {
                                $result .= PATH . $theme_name . '/' . $value . '/' . $value2 . '/preview.jpg';
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }

    static public function getAdminLink($url, $parent_dir)
    {
        $files1 = scandir($url);
        foreach ($files1 as $key => $value) {
            if (preg_match("/admin/", $value)) {
                return PATH . $parent_dir . '/' . $value;
            }
        }
        return 'not_active';
    }

    static public function getProjectLink($value)
    {
        return PATH . $value;
    }

    static public function get_server_link($value)
    {
        if (file_exists(PATH_ROOT . $value . '/helper.php')) {
            return PATH . $value . '/helper.php';
        } else {
            return 'not_active';
        }
    }

    static public function getThemeName($url)
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
        return 'default-bootstrap';
    }

    static public function is_exception_dir($dir_name, $exception_dirs)
    {
        foreach ($exception_dirs as $dir) {
            if ($dir_name === $dir) {
                return true;
            }
        }

        return false;
    }

    static public function isAdminPage()
    {
        if ($_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) return true;

        return false;
    }

    static public function index_fixer()
    {
        $file = PATH_ROOT . CORE_DIR_NAME . 'index_fixer\files\index.php';
        function getAllFiles($path, $index, $list = array())
        {
            if (file_exists($path)) {
                $files = scandir($path);
                if (!array_search('index.php', $files)) {
                    $list[] = $path;
                    copy($index, $path . 'index.php');
                }
                foreach ($files as $file) {
                    if ($file == '..' || $file == '.') {
                        continue;
                    } elseif (is_dir($path . $file)) {
                        $list = getAllFiles($path . $file . '\\', $index, $list);
                    }
                }

                return $list;
            }
            return $list;
        }

        if (isset($_POST['path'])) {
            $path = trim($_POST['path']);
            if (substr($path, -1) == '\\') $path = substr($path, 0, -1);
            $path = $path . '\\';
            $path_2 = $path . 'modules\\';
            $result = getAllFiles($path, $file);
            $result = array_merge($result, getAllFiles($path_2, $file));
        }
        $massage = '';
        if (count($result) > 0) {
            $massage = 'You fix ' . count($result) . ' index.php files.';
        } else {
            $massage = 'All index.php files already fixed :-)';
        }

        return $massage;
    }

    static public function clearDb($data_base)
    {
        $db = new SafeMySQL(['db' => $data_base]);
        $tables = $db->getAll('SHOW TABLES');

        foreach ($tables as $table) {
            $db->query('DROP TABLE IF EXISTS ' . $table['Tables_in_' . $data_base]);
        }
        echo '<h1>Data base ' . $data_base . ' is clear!</h1>';
        exit;
    }
}
