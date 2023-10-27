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
            $this->path = $path;
            $this->root = $root ?? $_SERVER['DOCUMENT_ROOT'];
            if (!is_file($this->root . $path)) throw new Exception('path is not a valid directory');
            $this->baseName = basename($path);
            $this->parent = dirname($path);
            $this->extension = pathinfo($path, PATHINFO_EXTENSION);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function display($user)
    {
        $this->title($user);
        if ($this->extension == 'html') {
            include($this->root . $this->path);
        } else {
            echo '<div class="article">';
            include($this->root . $this->path);
            echo '</div>';
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

    public function buildHTMLRow()
    {
        return ResourceHtml::{$this->extension}($this->parent, $this->path, $this->baseName);
    }
}
