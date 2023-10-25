<?php

class FileHandler
{
    public $location;
    public $rootPath;
    public $fullPath;
    public $ext;

    public $name;

    public function __construct(string $location, $rootPath = '/var/www/html')
    {
        try {

            if (!file_exists($rootPath . $location) && !is_dir($rootPath . $location))
                throw new Exception('Path either does not exist or your path is not a directory.');

            $this->rootPath = $rootPath;
            $this->location = $location;
            $this->fullPath = $this->rootPath . $this->location;
            $this->name = basename($location);
            $this->ext = pathinfo($this->location, PATHINFO_EXTENSION);
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }


    public function retrieveContent()
    {
        $contents = scandir($this->fullPath);

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

            $contInfo['fullPath'] = join(DIRECTORY_SEPARATOR, array($this->location, $content));
            $contInfo['name'] = $content;

            if (is_dir($this->rootPath . $contInfo['fullPath'])) {
                $contInfo['type'] = 'dir';
            } else if (is_file($this->rootPath . $contInfo['fullPath'])) {
                $contInfo['type'] = 'file';
            }

            $contInfo['ext'] = pathinfo($content, PATHINFO_EXTENSION);

            array_push($contentInfo, $contInfo);
        }

        return $contentInfo;
    }
    public function htmlRow($type, $target, $name, $ext)
    {
        $htmlContent = '';
        if ($type == 'dir') {
            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" data-location="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items" data-type="dir" class="open-row">
            <div class="arrow closed-folder">
            </div>
            <div class="narrow">
            <a href="index.php?target=' . $target . '&view=folder" class="folder-icon">
            </a>
            </div>
            <div>
            <a href="index.php?target=' . $target . '&view=folder">' . $name . '</a>
            </div>
            </div>
            </td>
            </tr>';
        }
        //check for pdf
        elseif ($ext == 'pdf') {
            $target = preg_replace('/#/', '%23', $target);
            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div>
            <div class="narrow" >
            <a href="' . $target . '" target="_blank">
            <img src="./.policy-code/images/pdf-icon.png" class="folder" title="View PDF">
            </a>
            </div>
            <div>
            <a href="' . $target . '?target=' . $target . '" target="_blank">' . $name . '</a>
            </div>
            </div>
            </td>
            </tr>';
        }

        //test for webarchive
        elseif ($ext == 'webarchive') {

            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow"></div>
            <div class="narrow" >
            <a href="' . $target . '" download>
            <img src="./.policy-code/images/file.png" class="folder" title="Download Web Archive">
            </a>
            </div>
            <div>
            <a href="' . $target . '" download>' . $name . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        }

        //test for pages, numbers, xls
        elseif ($ext == 'pages' || $ext == 'numbers' || $ext == 'xls') {

            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div>
            <div class="narrow" >
            <a href="' . $target . '" download>
            <img src="./.policy-code/images/file.png" class="folder" title="Download File">
            </a>
            </div>
            <div>
            <a href="' . $target . '" download>' . $name . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        }

        //test for image files and build appropriate anchor
        elseif ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {

            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div><div class="narrow"><a href="' . $target . '" target="_blank">
            <img src="./.policy-code/images/image-icon.png" class="folder" title="View Image">
            </a>
            </div>
            <div>
            <a href="' . $target . '?target=' . $target . '" target="_blank">' . $name . '</a>
            </div>
            </div>
            </td>
            </tr>';
        }
        //test for php files and list everything but .php
        elseif ($ext != 'php' && $type == 'file') {

            $htmlContent = '<tr data-type="' . $type . '" data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow"></div>
            <div class="narrow" >
            <a href="index.php?target=' . $target . '&view=file' . '">
            <img src="./.policy-code/images/file.png" class="folder"></a></div>
            <div>
            <a href="index.php?target=' . $target . '&view=file' . '">' . $name . '</a>
            </div>
            </div>
            </td>
            </tr>' . "\n\n";
        }

        return $htmlContent;
    }
    public function display()
    {

        $this->fileTitle();
        if ($this->ext == 'html') {
            include($this->fullPath);
        } else {
            echo '<div class="article">';
            include($this->fullPath);
            echo '</div>';
        }
    }

    public function fileTitle()
    {
        echo '<div class="title">
		<div class="sixteen columns">
	<img onclick="history.back()" src="./.policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back">
    <a href="index.php">
    <img src="./.policy-code/images/home-icon-35.png" class="scale-with-grid" style="border: none;">
    </a>
	<span class="titleText">Viewing  ' . $this->name . ' </span>
    </div>
    </div>';
    }

    public function DirectoryTitle($user)
    {
        //build page header
        echo '<div class="title">
    <div class="two-thirds column" style="display:flex;align-items:center;justify-content: space-around;">
    <img onclick="history.back()" src="./.policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back">
    <a href="index.php">
    <img src="./.policy-code/images/home-folder-icon-35.png" class="scale-with-grid" style="border: none;" title="Home">
    </a>
    <span class="titleText">' . $user;
        echo ' ' . $this->name . '</span> 
        
        <div class="adding-files">
            <div class="file-button" id="file-button" title="New Text File inside">
            <img src="./.policy-code/images/new-file-icon-white.png">
            </div>
            <div class="file-button" id="folder-button" title="New Folder inside ">
            <img src="./.policy-code/images/new-folder-icon.png">
            </div>
            <div class="file-button" id="upload-files-button" title="Upload Files into">
            <img src="./.policy-code/images/upload-file-icon.png"></div>
        </div>';


        echo '</div>
        <div class="one-third column">';
        include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/search.html');

        echo '</div>
        </div>';
    }
    public function buildRows()
    {
        foreach ($this->retrieveContent() as $i) {
            $target = $i['fullPath'];
            echo $this->htmlRow($i['type'], $target, $i['name'], $i['ext']);
        }
    }
}
