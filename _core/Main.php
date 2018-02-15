<?php
require_once './_core/config.php';
require_once './_core/function.php';
require_once './_core/SafeMySQL.php';


class Main
{
  static public $preview = 'preview';
  static public $admin_link = 'admin';
  static public $project_link = 'project_link';
  static public $project_name = 'project_name';
  static public $helper_link = 'helper_link';
  static public $theme_name = 'theme_name';
  static public $bd_name = 'bd_name';
  static public $structure = array();

  static public function getNewDirStructure()
  {
    $content = array();
    $files1 = scandir(PATH_ROOT);

    foreach ($files1 as $key => $value) {
      $item = array();
      if (
        !Functions::is_exception_dir($files1[$key], ConfigVar::$exception_dirs) &&
        is_dir(PATH_ROOT . $value)
      ) {
        if (Functions::getPreview(PATH_ROOT . $value, $value)) {
          $item[self::$preview] = Functions::getPreview(PATH_ROOT . $value, $value);
        } else {
          $item[self::$preview] = PREVIEW_IMG_BASE;
        }
        $item[self::$project_name] = $value;
        $item[self::$admin_link] = Functions::getAdminLink(PATH_ROOT . $value, $value);
        $item[self::$project_link] = Functions::getProjectLink($value);
        $item[self::$helper_link] = Functions::get_server_link($value);
        $item[self::$theme_name] = Functions::getThemeName(PATH_ROOT . $value);

        array_push($content, $item);
      }
    }

    return json_encode($content, JSON_UNESCAPED_SLASHES);
  }

  static public function fetchDetection()
  {
    if (isset($_POST['get_project_list'])) {
      echo Main::getNewDirStructure();
      exit;
    }

    if (isset($_POST['theme_name'])) {
      Functions::create_base_pack_theme($_POST['project_name'], $_POST['theme_name']);
    };

    if (isset($_POST['clear_data_base'])) {
      Functions::clearDb($_POST['clear_data_base']);
    }

    if (isset($_POST['show_modules'])) {
      Functions::showModules($_POST['show_modules']);
    }

    if (isset($_POST['create_git_structure'])) {
      Functions::create_base_pack_theme($_POST['create_git_structure']);
    }
  }
}

Main::fetchDetection();