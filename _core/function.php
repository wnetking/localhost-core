<?php


class Functions
{
  static public function create_base_pack_theme($project)
  {
    if (Functions::isAdminPage()) {
      $theme_name = Functions::getThemeName(PATH_ROOT . $project);
      $folder_name = '_FORGIT';
      $path_to_theme = PATH_ROOT . $project . '/' . $folder_name . '/' . $theme_name;
      $config_file = PATH_ROOT . $project . '/config/settings.inc.php';
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
        require_once PATH_ROOT . $project . '/config/settings.inc.php';
        fopen(PATH_ROOT . $project . '/' . $folder_name . '/' . $theme_name . '/prestashop_' . _PS_VERSION_ . '.txt', 'w');
      }

      echo 'Structure create, check ' . $folder_name . ' folder  in project ' . $project . '.';
      exit;
    } else {
      echo 'Sorry you can\'t create structure';
      exit;
    }
  }

  static public function getPreview($url, $theme_name)
  {
    $result = '';
    if(file_exists($url . '/app/config/parameters.php')){
      $parameters = require(PATH_ROOT . $theme_name . '/app/config/parameters.php');

      if (array_key_exists('parameters', $parameters)) {
        $db = new SafeMySQL([
          'db' => $parameters['parameters']['database_name']
        ]);
        $tables = $db->getAll('SHOW TABLES');

        if($tables){
          $active_theme_name = $db->getOne('SELECT theme_name FROM ' . $parameters['parameters']['database_prefix'] . 'shop WHERE id_shop=1');
          $result .= PATH . $theme_name . '/themes/' . $active_theme_name . '/preview.png';
        }
      }
    }else{
      $files1 = scandir($url);
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
    return false;
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
      return false;
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


  static public function clearDb($project,$type)
  {
    if (Functions::isAdminPage()) {
      if($type === "PS16") {
        $config_file = PATH_ROOT . $project . '/config/settings.inc.php';

        if (file_exists($config_file)) {
          require_once PATH_ROOT . $project . '/config/settings.inc.php';


          $db = new SafeMySQL(['db' => _DB_NAME_]);
          $tables = $db->getAll('SHOW TABLES');

          foreach ($tables as $table) {
            $db->query('DROP TABLE IF EXISTS ' . $table['Tables_in_' . _DB_NAME_]);
          }

          echo 'Data base ' . _DB_NAME_ . ' is clear!';
          exit;
        }
      } else if($type === "PS17"){
        $parameters = require(PATH_ROOT . $project . '/app/config/parameters.php');

        if (array_key_exists('parameters', $parameters)) {
          $db = new SafeMySQL([
            'db' => $parameters['parameters']['database_name']
          ]);

          $tables = $db->getAll('SHOW TABLES');

          foreach ($tables as $table) {
            $db->query('DROP TABLE ' .
              $table['Tables_in_' . $parameters['parameters']['database_name']]);
          }
          echo 'Data base ' . $parameters['parameters']['database_name'] . ' is clear!';
          exit;
        }
      }
    } else {
      echo 'Sorry, you can\'t do this =(';
      exit;
    }
  }

  static public function showModules($project, $type)
  {
    if (file_exists(PATH_ROOT . $project . '/config/settings.inc.php') && $type === "PS16") {
      require_once PATH_ROOT . $project . '/config/settings.inc.php';

      $db = new SafeMySQL(['db' => _DB_NAME_]);
      $modules_array = $db->query('SELECT name, version FROM ' . _DB_PREFIX_ . 'module');
      $modules = array();
      foreach ($modules_array as $module) {
        $item = array();
        if (preg_match("/^tm/", $module['name']) || preg_match("/^jx/", $module['name']) ||
          $module['name'] == 'sampledatainstall'
        ) {
          $item['name'] = $module['name'];
          $item['version'] = $module['version'];
          array_push($modules, $item);
        }
      }
      $value = Array
      (
        'project_name' => $project,
        'shop_name' => $db->getOne('SELECT value FROM ' . _DB_PREFIX_ . 'configuration WHERE name LIKE "PS_SHOP_NAME%"'),
        'prestashop_vesion' => _PS_VERSION_,
        'shop_create' => _PS_CREATION_DATE_,
        'data_base' => _DB_NAME_,
        'modules' => $modules
      );

      print_r(json_encode($value, JSON_UNESCAPED_SLASHES));
    } else if(file_exists(PATH_ROOT . $project . '/app/config/parameters.php') && $type === "PS17"){
      $parameters = require(PATH_ROOT . $project . '/app/config/parameters.php');

      if (array_key_exists('parameters', $parameters)) {
        $db = new SafeMySQL([
          'db' => $parameters['parameters']['database_name']
        ]);
        $modules_array = $db->query('SELECT name, version FROM ' . $parameters['parameters']['database_prefix'] . 'module');
        $modules = array();
        foreach ($modules_array as $module) {
          $item = array();
          if (preg_match("/^jx/", $module['name']) || preg_match("/^tm/", $module['name']) ||
            $module['name'] == 'sampledatainstall'
          ) {
            $item['name'] = $module['name'];
            $item['version'] = $module['version'];
            array_push($modules, $item);
          }
        }

        $value17 = Array
        (
          'project_name' => $project,
          'shop_name' => $db->getOne('SELECT value FROM ' . $parameters['parameters']['database_prefix'] . 'configuration WHERE name LIKE "PS_SHOP_NAME%"'),
          'prestashop_vesion' => $db->getOne('SELECT value FROM ' . $parameters['parameters']['database_prefix'] . 'configuration WHERE name LIKE "PS_VERSION_DB%"'),
          'shop_create' => $parameters['parameters']['ps_creation_date'],
          'data_base' => $parameters['parameters']['database_name'],
          'modules' => $modules
        );

        print_r(json_encode($value17, JSON_UNESCAPED_SLASHES));
      }
    }else{
      $other = Array
        (
          'project_name' => $project,
        );
        print_r(json_encode($other, JSON_UNESCAPED_SLASHES));
    }
    exit;
  }

  static public function getProjectType($project){
    $files = scandir(PATH_ROOT . $project);

    foreach ($files as $key => $value) {
      if ($value == 'app') {
        return "PS17";
      }
    }

    foreach ($files as $key => $value) {
      if ($value == 'Core') {
        return "PS16";
      }
    }

    return "other";
  }

  static public function removeCatalog($project)
  {

    function deleteDirectory($dir) {
      system('rm -rf ' . escapeshellarg($dir), $retval);
      return $retval == 0; // UNIX commands return zero on success
    }
    if (Functions::isAdminPage()) {
      if (is_dir(PATH_ROOT . $project) && deleteDirectory(PATH_ROOT . $project)) {
        echo 'Projec ' . $project . ' was deleted!';
        exit;
      }
    }else{
      echo 'Sorry, you can\'t do this =(';
      exit;
    }

    exit;
  }

  static public function createProject($projectName){
    function makeDir($path)
    {
        $ret = mkdir($path);
        return $ret === true || is_dir($path);
    }

  }
}