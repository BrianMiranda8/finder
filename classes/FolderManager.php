<?php

class FolderManager
{
    public $path;
    public $baseName;
    protected $parent;
    protected $root;
    protected $manager;
    public $_Exclude = ['php'];

    public function __construct($path, $resourceManager, $root = null)
    {
        try {
            $this->path = $path;
            $this->root = $root ?? $_SERVER['DOCUMENT_ROOT'];
            if (!is_dir($this->root . $path)) throw new Exception('path is not a valid directory');
            $this->baseName = basename($path);
            $this->parent = dirname($path);
            $this->manager = $resourceManager;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function display($user, $home)
    {

        $setBack = (!isset($_GET['target']) || $_GET['target'] == '') ? true : false;
        ResourceHtml::Directorytitle($user, $home, $this->baseName, $setBack, true);
        echo <<<"EOL"
            <table id='main-table'>
                <tbody>
                    {$this->buildRows()}
                </tbody>
           </table>
        EOL;
    }


    public function buildRows()
    {
        $rows = '';
        $contents = $this->get_folder_content();
        if (!empty($contents)) {

            foreach ($contents as $i) {

                if ($i['ext'] == '') {
                    $rows .= ResourceHtml::{$i['type']}($i['parent'], $i['fullPath'], $i['name']);
                } else {
                    $rows .= ResourceHtml::{$i['ext']}($i['parent'], $i['fullPath'], $i['name']);
                }
            }
        } else {
            $rows .= ResourceHtml::empty($this->path, $this->path, 'Empty');
        }

        return $rows;
    }

    public function get_folder_content()
    {
        $contents = scandir($this->root . $this->path);

        $contents = $content = array_diff($contents, array('.', '..'));

        $contents = array_filter($contents, function ($dir) {
            return strpos($dir, '.') !== 0;
        });
        $contentInfo = array();

        foreach ($contents as $content) {
            $extension = pathinfo($content, PATHINFO_EXTENSION);

            if (in_array($extension, $this->_Exclude)) continue;

            $contInfo = array(
                'type' => '',
                'fullPath' => '',
                'parent' => '',
                'name' => '',
                'ext' => ''
            );

            $contInfo['ext'] = pathinfo($content, PATHINFO_EXTENSION);
            $contInfo['parent'] = join(DIRECTORY_SEPARATOR, array($this->path));
            $contInfo['fullPath'] = join(DIRECTORY_SEPARATOR, array($this->path, $content));
            $contInfo['name'] = $content;

            if (is_dir($this->root . $contInfo['fullPath'])) {
                $contInfo['type'] = 'directory';
            } else if (is_file($this->root . $contInfo['fullPath'])) {
                $contInfo['type'] = 'file';
            }


            array_push($contentInfo, $contInfo);
        }

        return $contentInfo;
    }

    public function buildHTMLRow()
    {
        return ResourceHtml::directory($this->parent, $this->path, $this->baseName);
    }
}
