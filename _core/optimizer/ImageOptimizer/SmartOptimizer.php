<?php
namespace ImageOptimizer;

use ImageOptimizer\Exception\Exception;
use ImageOptimizer\TypeGuesser\SmartTypeGuesser;
use ImageOptimizer\TypeGuesser\TypeGuesser;

class SmartOptimizer implements Optimizer
{
    /**
     * @var Optimizer[]
     */
    private $optimizers;
    private $typeGuesser;

    public function __construct(array $optimizers, TypeGuesser $typeGuesser = null)
    {
        $this->optimizers = $optimizers;
        $this->typeGuesser = $typeGuesser ?: new SmartTypeGuesser();
    }

    public function optimize($filepath)
    {
        $type = $this->typeGuesser->guess($filepath);
        if (!isset($this->optimizers[$type])) {
            throw new Exception(sprintf('Optimizer for type "%s" not found.', $type));
        }
        $this->optimizers[$type]->optimize($filepath);
    }

    public function cleanFolder($path)
    {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $this->checkPerms($path . $file, 0777);
                if (is_dir($path . $file)) {
                    $this->cleanFolder($path . $file . '/');
                    rmdir($path . $file);
                } else {
                    unlink($path . $file);
                }
            }
        }

        return true;
    }

    protected function checkPerms($file, $new_perms)
    {
        $perms = fileperms($file);
        $info = '';
        // Owner
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x') :
            (($perms & 0x0800) ? 'S' : '-'));
        // Group
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x') :
            (($perms & 0x0400) ? 'S' : '-'));
        // World
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x') :
            (($perms & 0x0200) ? 'T' : '-'));
        if ($info != 'rwxrwxrwx') {
            chmod($file, $new_perms);
        }

        return true;
    }

    protected function getExtension($filename)
    {
        $path_info = pathinfo($filename);

        return $path_info['extension'];
    }

    public function getAllFiles($input_path, $output_path, $replace = false, $list = array())
    {
            $files = scandir($input_path);
            if ($replace) {
                $output_path = $input_path;
            }
            foreach ($files as $file) {
                if ($file == '..' || $file == '.') {
                    continue;
                } elseif (is_dir($input_path . $file)) {
                    if (!$replace) {
                        if (!file_exists($output_path . $file)) {
                            mkdir($output_path . $file);
                        }
                    }
                    $list = $this->getAllFiles($input_path . $file . '\\', $output_path . $file . '\\', $replace, $list);
                } elseif (($this->getExtension($input_path . $file) == 'jpg' && filesize($input_path . $file) > 20000) || ($this->getExtension($input_path . $file) == 'png' && filesize($input_path . $file) > 20000)) {
                    if (!$replace) {
                        copy($input_path . $file, $output_path . $file);
                    }
                    $list[] = $output_path . $file;
                }
            }

            return $list;
    }

    public function checkPath($input_path, $output_path)
    {
        if (is_dir($input_path)) {
            return true;
        } elseif ((is_file($input_path) && $this->getExtension($input_path) == 'jpg') || (is_file($input_path) && $this->getExtension($input_path) == 'png')) {
            $output_path .= basename($input_path);
            copy($input_path, $output_path);
            return array($output_path);
        } else {
            return false;
        }
    }

    public function patch($file)
    {
        $old_size = filesize($file);
        if ($this->getExtension($file) == 'jpg' && mime_content_type($file) == 'image/png') {
            $input_path = dirname($file);
            $newname = basename($file, ".jpg") . ".png";
            rename($file, $input_path . '/' . $newname);
            $this->optimize($input_path . '/' . $newname);
            $newname = basename($input_path . '/' . $newname, ".png") . ".jpg";
            rename($input_path . '/' . basename($file, ".jpg") . ".png", $input_path . '/' . $newname);
            clearstatcache();
            return $old_size - filesize($file);
        } elseif (($this->getExtension($file) == 'jpg' && filesize($file) > 20000) || ($this->getExtension($file) == 'png' && filesize($file) > 20000)) {
            $this->optimize($file);
            clearstatcache();
            return $old_size - filesize($file);
        }
    }

    public function createZip($file_name, $path, $input_path)
    {
        if (file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }
        $zip = new \ZipArchive();
        $zip->open($path . $file_name, \ZipArchive::OVERWRITE | \ZipArchive::CREATE);
        $this->archiveFolders($input_path, $zip);
        $zip->close();
    }

    protected function archiveFolders($path, $ZipArchiveObj, $zip_path = '')
    {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                if (is_dir($path . $file)) {
                    $ZipArchiveObj->addEmptyDir($zip_path . $file);
                    $new_zip_path = $zip_path . $file . '/';
                    $new_path = $path . $file . '/';
                    $this->archiveFolders($new_path, $ZipArchiveObj, $new_zip_path);
                } else {
                    $ZipArchiveObj->addFile($path . $file, $zip_path . $file);
                }
            }
        }
    }
}