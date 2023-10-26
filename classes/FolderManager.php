<?php

class Folder implements ResourceInterface
{
    public $path;
    public $baseName;
    public $parent;
    public $root;
    public function __construct($path, $root = null)
    {
        try {
            if (!is_dir($path)) throw new Exception('path is not a valid directory');
            $this->path = $path;
            $this->baseName = basename($path);
            $this->parent = dirname($path);
            $this->root = $root ?? $_SERVER['DOCUMENT_ROOT'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function title($user)
    {
        //build page header

        echo <<<"EOL"
                <div class="title">
                    <div class="two-thirds column" style="display:flex;align-items:center;justify-content: space-around;">
                    <img onclick="history.back()" src="./.policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back">
                    <a href="index.php">
                    <img src="./.policy-code/images/home-folder-icon-35.png" class="scale-with-grid" style="border: none;" title="Home">
                    </a>
                    <span class="titleText">$user $this->baseName</span> 
                        
                        <div class="adding-files">
                            <div class="file-button" id="file-button" title="New Text File inside $this->baseName">
                            <img src="./.policy-code/images/new-file-icon-white.png">
                            </div>
                            <div class="file-button" id="folder-button" title="New Folder inside $this->baseName">
                            <img src="./.policy-code/images/new-folder-icon.png">
                            </div>
                            <div class="file-button" id="upload-files-button" title="Upload Files into $this->baseName">
                            <img src="./.policy-code/images/upload-file-icon.png"></div>
                        </div>
                </div>
                <div class="one-third column">
        EOL;



        echo '</div>
        <div class="one-third column">';

        include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/search.php');

        echo '</div>
        </div>';
    }

    public function row()
    {
        $htmlContent = '<tr data-type="dir" data-parent="' . $this->parent . '" data-src="' . $this->path . '" data-location="' . $this->path . '" draggable="true">
        <td>
        <div class="stuff-items" data-type="dir" class="open-row">
        <div class="arrow closed-folder">
        </div>
        <div class="narrow">
        <a href="index.php?target=' . $this->path . '&view=folder" class="folder-icon">
        </a>
        </div>
        <div>
        <a href="index.php?target=' . $this->path . '&view=folder">' . $this->baseName . '</a>
        </div>
        </div>
        </td>
        </tr>';
        return $htmlContent;
    }

    public function extract()
    {
        $contents = scandir($this->path);

        $contents = $content = array_diff($contents, array('.', '..'));

        $contents = array_filter($contents, function ($dir) {
            return strpos($dir, '.') !== 0;
        });
        $contentInfo = array();

        foreach ($contents as $content) {

            $contInfo = array(
                'type' => '',
                'fullPath' => '',
                'name' => '',
                'ext' => ''
            );

            $contInfo['fullPath'] = join(DIRECTORY_SEPARATOR, array($this->path, $content));;
            $contInfo['name'] = $content;

            if (is_dir($this->path)) {
                $contInfo['type'] = 'dir';
            } else if (is_file($this->path)) {
                $contInfo['type'] = 'file';
            }

            $contInfo['ext'] = pathinfo($content, PATHINFO_EXTENSION);

            array_push($contentInfo, $contInfo);
        }

        return $contentInfo;
    }
}
