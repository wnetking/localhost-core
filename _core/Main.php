<?php
require_once './_core/config.php';
require_once './_core/function.php';
require_once './_core/templateCore.php';
require_once './_core/SafeMySQL.php';


class Main
{
    static public $preview = 'preview';
    static public $admin_link = 'admin';
    static public $project_link = 'project_link';
    static public $project_name = 'project_name';
    static public $helper_link = 'helper_link';
    static public $theme_name = 'theme_name';
    static public $structure = array();

    static public function getDirStructure()
    {
        $files1 = scandir(PATH_ROOT);

        foreach ($files1 as $key => $value) {
            if (
                !Functions::is_exception_dir($files1[$key], ConfigVar::$exception_dirs) &&
                is_dir(PATH_ROOT . $value)
            ) {
                if (Functions::getPreview(PATH_ROOT . $value, $value)) {
                    self::$structure[$value][self::$preview] = Functions::getPreview(PATH_ROOT . $value, $value);
                } else {
                    self::$structure[$value][self::$preview] = PREVIEW_IMG_BASE;
                }
                self::$structure[$value][self::$project_name] = $value;
                self::$structure[$value][self::$admin_link] = Functions::getAdminLink(PATH_ROOT . $value, $value);
                self::$structure[$value][self::$project_link] = Functions::getProjectLink($value);
                self::$structure[$value][self::$helper_link] = Functions::get_server_link($value);
                self::$structure[$value][self::$theme_name] = Functions::getThemeName(PATH_ROOT . $value);
            }
        }
    }

    static public function printPagination()
    {
        $content = '';
        $templater = new Templater();

        print $content;
    }

    static public function printNav()
    {
        $templater = new Templater();
        $content = '';
        $value = Array
        (
            'if_link' => PATH . CORE_DIR_NAME . 'index_fixer',
            'optimazer_link' => PATH . CORE_DIR_NAME . 'optimazer'
        );

        $content .= $templater->tmp($value, 'nav.tpl');

        print $content;
    }

    static public function printProjects()
    {
        self::getDirStructure();
        $templater = new Templater(true);
        $content = '';
        foreach (self::$structure as $key => $value) {
            $content .= $templater->tmp($value, 'template.tpl');
        }

        print $content;
    }

    static public function getStructure()
    {
        self::getDirStructure();
        return self::$structure;
    }

    static public function getJSONstructure()
    {
        self::getDirStructure();
        return json_encode(self::$structure, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
    }

    static public function ajaxDetected()
    {
        if (isset($_POST['clear_db'])) {
            Functions::clearDb($_POST['clear_db']);
        }

        if (isset($_POST['show_more'])) {
            if (file_exists(PATH_ROOT . $_POST['project_name'] . '/config/settings.inc.php')) {
                require_once PATH_ROOT . $_POST['project_name'] . '/config/settings.inc.php';
                $templater = new Templater();
                $content = '';
                $db = new SafeMySQL(['db' => _DB_NAME_]);
                $modules_array = $db->query('SELECT name, version FROM ' . _DB_PREFIX_ . 'module');
                $modules ='';
                foreach ($modules_array as $module){
                    if(preg_match("/^tm/", $module['name']) || $module['name'] == 'sampledatainstall') $modules .= '<tr>' . '<td>'.$module['name'].'</td><td>'.$module['version'].'</td>'.'</tr>';
                }
                $value = Array
                (
                    'project_name' => $_POST['project_name'],
                    'image' => $_POST['image'],
                    'theme_name' => $_POST['show_theme'],
                    'shop_name' => $db->getOne('SELECT name FROM ' . _DB_PREFIX_ . 'shop WHERE id_shop = 1'),
                    'prestashop_vesion' => _PS_VERSION_,
                    'shop_create' => _PS_CREATION_DATE_,
                    'data_base' => _DB_NAME_,
                    'modules' => $modules
                );
                $content .= $templater->tmp($value, 'show-more.tpl');
                print $content;
            }
            exit;
        }
        if (isset($_POST['create_git'])) {
            Functions::create_base_pack_theme($_POST['project_name_git'], $_POST['theme_name_git']);
        };
    }

    static public function setJsConstant()
    {
        $content = '';

        if (Functions::isAdminPage()) {
            $content = 'config.isAdminPage = true;';
        }
        $content .= 'config.PATH_TPL = "' . PATH . CORE_DIR_NAME . TPL_DIR_NAME . '";';
        $content .= 'config.PATH_CORE = "' . PATH . CORE_DIR_NAME . '";';
        $content .= 'config.PATH = "' . PATH . '";';

        print $content;
    }

    static public function printMassage($type, $massage)
    {
        $class_name = 'massage ';
        $content = '';
        if ($type == 'error') $class_name .= 'error';
        if ($type == 'succes') $class_name .= 'succes';

        $content .= '<div class="' . $class_name . '">' . $massage . '</div>';

        print $content;
    }
}

Main::ajaxDetected();
if (isset($_POST['theme_name'])) {
    Functions::create_base_pack_theme($_POST['project_name'], $_POST['theme_name']);
};