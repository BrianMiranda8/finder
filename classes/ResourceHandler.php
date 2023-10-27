<?php


class ResourceHandler
{

    private $location;
    private $rootPath;
    private $fullPath;
    private $ext;
    private $name;
    private $type;
    private $ResourceHandler;

    public function __construct(string $location, $rootPath = null)
    {
        try {

            $this->rootPath = $rootPath ?? $_SERVER['DOCUMENT_ROOT'];
            $this->location = $location;
            if (!file_exists($this->rootPath . $location) && !is_dir($this->rootPath . $location))
                throw new Exception('Path either does not exist or your path is not a directory.');
            $this->fullPath = $this->rootPath . $this->location;
            $this->name = basename($location);
            $this->ext = pathinfo($this->location, PATHINFO_EXTENSION);

            if (is_dir($this->fullPath)) {
                $this->type = 'directory';
                $this->ResourceHandler = new FolderManager($location, ResourceHtml::class);
            } elseif (is_file($this->fullPath)) {
                $this->type = 'file';
                $this->ResourceHandler = new FileManager($location);
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }

    public function get_resource_info()
    {
        return array("location" => $this->location, 'rootPath' => $this->rootPath, 'ext' => $this->ext, 'name' => $this->name, 'type' => $this->type);
    }

    public function showView($user)
    {

        $this->ResourceHandler->display($user);
    }

    public function get_handler()
    {
        return $this->ResourceHandler;
    }

    static function buildSearchView($dir, $keyword)
    {
        $show = ResourceHandler::searchFilesWithSubstring($dir, $keyword);
        $rows = "";
        if (!empty($show)) {

            foreach ($show as $i) {

                if ($i['ext'] == '') {
                    $rows .= ResourceHtml::{$i['type']}($i['parent'], $i['path'], $i['basename']);
                } else {
                    $rows .= ResourceHtml::{$i['ext']}($i['parent'], $i['path'], $i['basename']);
                }
            }
        } else {
            $rows .= ResourceHtml::empty('empty', 'empty', "No Seach Found");
        }
        return $rows;
    }

    static function searchFilesWithSubstring($directory, $substring)
    {
        try {

            $matches = [];

            $files = glob($_SERVER['DOCUMENT_ROOT'] . $directory . '/*');
            foreach ($files as $file) {
                $contInfo = array();

                $cleanFile = str_replace('/var/www/html', '', $file);
                if (strpos(basename(strtolower($file)), $substring) !== false) {
                    $contInfo['ext'] = pathinfo($cleanFile, PATHINFO_EXTENSION);
                    $contInfo['parent'] = dirname($cleanFile);
                    $contInfo['path'] = $cleanFile;

                    $contInfo['basename'] = basename($cleanFile);

                    if (is_dir($file)) {
                        $contInfo['type'] = 'directory';
                    } else if (is_file($file)) {
                        $contInfo['type'] = 'file';
                    }
                    $matches[] = $contInfo;
                }

                if (is_dir($file)) {
                    $matches = array_merge($matches, self::searchFilesWithSubstring($cleanFile, $substring));
                }
            }
            return $matches;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function buildResourceRow()
    {
        return  $this->ResourceHandler->buildHTMLRow();
    }
}
