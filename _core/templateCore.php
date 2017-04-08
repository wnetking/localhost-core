<?php

class Templater
{
    private $variables;
    private $path;

    public function __construct($add_icons = false)
    {
        if ($add_icons) {
            $this->variables['icon_admin_panel'] = file_get_contents('./_core/img/user.svg');
            $this->variables['icon_copy'] = file_get_contents('./_core/img/file.svg');
            $this->variables['icon_helper'] = file_get_contents('./_core/img/multimedia.svg');
            $this->variables['icon_pack'] = file_get_contents('./_core/img/folder.svg');
            $this->variables['icon_settings'] = file_get_contents('./_core/img/wrench.svg');
        }
    }

    public function tmp($data, $path = NULL)
    {
        $this->path = $path;
        $tmp = file_get_contents(TPL_PATH . $this->path);

        foreach ($data as $key => $value) {
            $this->variables[$key] = $value;
        }

        foreach ($this->variables as $key => $value) {
            $tmp = str_replace('{' . $key . '}', $value, $tmp);
        }

        return $tmp;
    }
}