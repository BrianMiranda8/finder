<?php

class FileManager
{
    public $path;
    public $baseName;
    public $parent;
    public $extension;
    public $root;
    public function __construct($path, $root = null)
    {
        try {
            if (!is_file($path)) throw new Exception('path is not a valid directory');
            $this->path = $path;
            $this->baseName = basename($path);
            $this->parent = dirname($path);
            $this->extension = pathinfo($path, PATHINFO_EXTENSION);
            $this->root = $root ?? $_SERVER['DOCUMENT_ROOT'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function title()
    {
        echo '<div class="title">
		<div class="sixteen columns">
	<img onclick="history.back()" src="./.policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back">
    <a href="index.php">
    <img src="./.policy-code/images/home-icon-35.png" class="scale-with-grid" style="border: none;">
    </a>
	<span class="titleText">Viewing  ' . $this->baseName . ' </span>
    </div>
    </div>';
    }
    public function File()
    {

        $htmlContent = '<tr data-type="file" data-parent="' . $this->parent . '" data-src="' . $this->path . '" draggable="true">
        <td>
        <div class="stuff-items">
        <div class="arrow"></div>
        <div class="narrow" >
        <a href="index.php?target=' . $this->path . '&view=file' . '">
        <img src="./.policy-code/images/file.png" class="folder"></a></div>
        <div>
        <a href="index.php?target=' . $this->path . '&view=file' . '">' . $this->baseName . '</a>
        </div>
        </div>
        </td>
        </tr>' . "\n\n";

        return $htmlContent;
    }

    public function pdf()
    {
        $target = preg_replace('/#/', '%23', $this->path);
        $htmlContent = '<tr data-type="file" data-parent="' . $this->parent . '" data-src="' . $target . '" draggable="true">
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
            <a href="' . $target . '?target=' . $target . '" target="_blank">' . $this->baseName . '</a>
            </div>
            </div>
            </td>
            </tr>';
        return $htmlContent;
    }
    public function image()
    {
        $htmlContent = '<tr data-type="file" data-parent="' . $this->parent . '" data-src="' . $this->path . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div><div class="narrow"><a href="' . $this->path . '" target="_blank">
            <img src="./.policy-code/images/image-icon.png" class="folder" title="View Image">
            </a>
            </div>
            <div>
            <a href="' . $this->path . '?target=' . $this->path . '" target="_blank">' . $this->baseName . '</a>
            </div>
            </div>
            </td>
            </tr>';
        return $htmlContent;
    }
    public function Misc()
    {
        $htmlContent = '<tr data-type="file" data-parent="' . $this->parent . '" data-src="' . $this->path . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div>
            <div class="narrow" >
            <a href="' . $this->path . '" download>
            <img src="./.policy-code/images/file.png" class="folder" title="Download File">
            </a>
            </div>
            <div>
            <a href="' . $this->path . '" download>' . $this->baseName . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        return $htmlContent;
    }
    public function png()
    {
        return $this->image();
    }
    public function gif()
    {
        return $this->image();
    }
    public function jpeg()
    {
        return $this->image();
    }
    public function jpg()
    {
        return $this->image();
    }

    public function pages()
    {
        return $this->Misc();
    }

    public function numbers()
    {
        return $this->Misc();
    }
    public function xls()
    {
        return $this->Misc();
    }
    public function webarchive()
    {
        return $this->Misc();
    }
}
