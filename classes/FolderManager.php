<?php

class Folder implements ResourceInterface
{
    public $path;
    public $url;
    public function __construct($path)
    {
        try {
            if (!is_dir($path)) throw new Exception('path is not a valid directory');
            $this->path = $path;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function extract()
    {
    }

    public function display()
    {
    }
}
