<?php


class ResourceHandler
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

    public function display()
    {

        // $this->fileTitle();
        if ($this->ext == 'html') {
            include($this->fullPath);
        } else {
            echo '<div class="article">';
            include($this->fullPath);
            echo '</div>';
        }
    }




    // public function buildRows()
    // {
    //     foreach ($this->retrieveContent() as $i) {
    //         $target = $i['fullPath'];
    //         echo $this->htmlRow($i['type'], $target, $i['name'], $i['ext']);
    //     }
    // }
    // public function buildSearchRows($dir, $substring)
    // {
    //     $returnString = '';
    //     $searchResult = $this->buildSearchTable($dir, $substring);
    //     foreach ($searchResult as $i) {
    //         $target = str_replace('/var/www/html', '', $i['fullPath']);
    //         $returnString .= $this->searchRow($i['type'], dirname($target), $target, $i['name'], $i['ext']);
    //     }
    //     return $returnString;
    // }

    static function searchFilesWithSubstring($directory, $substring)
    {
        try {

            $matches = [];

            $files = glob($directory . '/*');
            foreach ($files as $file) {
                if (strpos(basename(strtolower($file)), $substring) !== false) {
                    $matches[] = array('basename' => basename($file), 'path' => $file);
                }
                if (is_dir($file)) {
                    $matches = array_merge($matches, ResourceHandler::searchFilesWithSubstring($file, $substring));
                }
            }
            return $matches;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
