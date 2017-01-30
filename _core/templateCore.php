<?php
define("PATH", "http://" . $_SERVER['HTTP_HOST'] . "/_core/tmp");

class Templater
{
    private $name_of_project;
    private $preview;
    private $admin;
    private $project_link;
    private $helper_link;
    private $theme_name;
    private $path;
    private $icon_admin_panel;
    private $icon_copy;
    private $icon_helper;

    public function tmp($data, $path = NULL)
    {
        $this->name_of_project = $data['project_name'];
        $this->preview = $data['preview'];
        $this->admin = $data['admin'];
        $this->project_link = $data['project_link'];
        $this->helper_link = $data['helper_link'];
        $this->theme_name = $data['theme_name'];
        $this->path = $path;
        $this->icon_admin_panel= file_get_contents('./_core/img/user.svg');
        $this->icon_copy= file_get_contents('./_core/img/file.svg');
        $this->icon_helper= file_get_contents('./_core/img/multimedia.svg');
        $this->icon_pack= file_get_contents('./_core/img/folder.svg');

        $tmp = file_get_contents(PATH . '/' . $this->path);
        $tmp = str_replace('{name_of_project}', $this->name_of_project, $tmp);
        $tmp = str_replace('{preview}', $this->preview, $tmp);
        $tmp = str_replace('{admin}', $this->admin, $tmp);
        $tmp = str_replace('{project_link}', $this->project_link, $tmp);
        $tmp = str_replace('{helper_link}', $this->helper_link, $tmp);
        $tmp = str_replace('{theme_name}', $this->theme_name, $tmp);
        $tmp = str_replace('{icon_admin_panel}', $this->icon_admin_panel, $tmp);
        $tmp = str_replace('{icon_copy}', $this->icon_copy, $tmp);
        $tmp = str_replace('{icon_helper}', $this->icon_helper, $tmp);
        $tmp = str_replace('{icon_pack}', $this->icon_pack, $tmp);

        return $tmp;
    }
}